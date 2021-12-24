<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\IDepartmentRepository;
use App\Repositories\ISpecializationRepository;
use App\Repositories\ISubjectRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    protected $subjectRepository;
    protected $departmentRepository;
    protected $specializationRepository;

    public function __construct(
        ISubjectRepository $subjectRepository,
        ISpecializationRepository $specializationRepository,
        IDepartmentRepository $departmentRepository
    ) {
        $this->subjectRepository = $subjectRepository;
        $this->departmentRepository = $departmentRepository;
        $this->specializationRepository = $specializationRepository;
    }

    public function index(Request $request)
    {
        $departmentFilter = $request->get('department-filter');
        $typeFilter = $request->get('type-filter');
        $keyword = $request->get('keyword');
        $departments = $this->departmentRepository->all()->pluck('name', 'id')->toArray();
        $subjects = $this->subjectRepository->withTrashedModel()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->when($typeFilter != null, function ($query) use ($typeFilter) {
                $query->where('type', $typeFilter);
            })
            ->when($departmentFilter, function ($query) use ($departmentFilter) {
                $query->whereHas('department', function ($query) use ($departmentFilter) {
                    $query->where('id', $departmentFilter);
                });
            })
            ->with('department')
            ->paginate(config('config.paginate'));

        return view('admin.subject.index', compact(
            'subjects',
            'departments',
            'departmentFilter',
            'typeFilter',
            'keyword'
        ));
    }

    public function create()
    {
        $departments = $this->departmentRepository->all()
            ->pluck('name', 'id');

        return view('admin.subject.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $this->subjectRepository->create([
            'name' => $request->get('name'),
            'credit' => $request->get('credit'),
            'type' => $request->get('basic')
                ? config('subject.type.basic')
                : config('subject.type.specialization'),
            'department_id' => $request->get('department_id'),
        ]);

        return $this->successRouteRedirect('admin.subjects.index');
    }

    public function edit($id)
    {
        $subject = $this->subjectRepository->find($id);
        if ($subject) {
            $subject = $subject->load('specializations');
        }
        $specializations = $this->specializationRepository->all();
        $departments = $this->departmentRepository->all();

        return view('admin.subject.edit', compact(
            'subject',
            'specializations',
            'departments'
        ));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $subject = $this->subjectRepository->find($id);
            $subject->update(
                array_merge(
                    ['semester' => $subject->type == config('subject.type.basic')  ? $request->get('semester') : null],
                    $request->only([
                        'name', 'credit',
                    ])
                )
            );
            $subject->specializations()
                ->sync($request->get('specializations'));
            DB::commit();

            return $this->successRouteRedirect('admin.subjects.index');
        } catch (Exception $e) {
            DB::rollBack();

            return $this->failRouteRedirect();
        }
    }

    public function destroy($id)
    {
        $result = $this->subjectRepository->delete($id);
        if ($result) {
            return $this->successRouteRedirect('admin.subjects.index');
        }

        return $this->failRouteRedirect();
    }

    public function restore($id)
    {
        $result = $this->subjectRepository->restore($id);
        if ($result) {
            return $this->successRouteRedirect('admin.subjects.index');
        }

        return $this->failRouteRedirect();
    }
}
