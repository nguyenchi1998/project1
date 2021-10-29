<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\IDepartmentRepository;
use App\Repositories\ISpecializationRepository;
use App\Repositories\ISubjectRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpecializationController extends Controller
{
    protected $specializationRepository;
    protected $subjectRepository;
    protected $departmentRepository;

    public function __construct(
        ISpecializationRepository $specializationRepository,
        IDepartmentRepository     $departmentRepository,
        ISubjectRepository        $subjectRepository
    ) {
        $this->specializationRepository = $specializationRepository;
        $this->subjectRepository = $subjectRepository;
        $this->departmentRepository = $departmentRepository;
    }

    public function index(Request $request)
    {
        $keyword = $request->get('keyword');
        $specializations = $this->specializationRepository->withTrashedModel()
            ->with(['subjects', 'department'])
            ->paginate(config('config.paginate'));

        return view('admin.specialization.index', compact('specializations', 'keyword'));
    }


    public function create()
    {
        $departments = $this->departmentRepository->all()->pluck('name', 'id');

        return view('admin.specialization.create', compact('departments'));
    }


    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $this->specializationRepository->create($request->only([
                'name',
                'min_credit',
                'total_semester',
                'department_id',
            ]));

            DB::commit();

            return $this->successRouteRedirect('admin.specializations.index');
        } catch (Exception $e) {
            DB::rollBack();

            return $this->failRouteRedirect();
        }
    }

    public function edit($id)
    {
        $specialization = $this->specializationRepository->find($id);
        if ($specialization) {
            $specialization = $specialization->load('subjects');
        }

        return view('admin.specialization.edit', compact('specialization'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->specializationRepository->update($id, $request->only([
                'name',
                'min_credit',
                'total_semester'
            ]));
            DB::commit();

            return $this->successRouteRedirect('admin.specializations.index');
        } catch (Exception $e) {
            DB::rollBack();

            return $this->failRouteRedirect();
        }
    }

    public function destroy($id)
    {
        $result = $this->specializationRepository->delete($id);

        if ($result) {
            return $this->successRouteRedirect('admin.specializations.index');
        }
        return $this->failRouteRedirect();
    }


    public function restore($id)
    {
        $result = $this->specializationRepository->restore($id);
        if ($result) {
            return $this->successRouteRedirect('admin.specializations.index');
        }

        return $this->failRouteRedirect();
    }

    public function chooseSubjectShow($id)
    {
        $specialization = $this->specializationRepository->find($id)->load('subjects');
        $specializationSubject = $specialization->subjects->pluck('id')->toArray();
        $subjects = $this->subjectRepository->where('type', '=', config('config.subject.type.specialization'))
            ->get();

        $subjects = $subjects->map(function ($subject) use ($specialization) {
            $subject['semester'] = $specialization->subjects->first(function ($subjectItem) use ($subject, $specialization) {
                return $specialization->subjects->contains('id', $subject->id) && $subjectItem->id ==  $subject->id;
            })->pivot->semester ?? null;
            return $subject;
        })
        ->sortByDesc('semester');

        return view('admin.specialization.choose_subject', compact('specialization', 'subjects', 'specializationSubject'));
    }

    public function chooseSubject(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $subjectIds = $request->get('subjects');
            $specialization = $this->specializationRepository->find($id);
            $specialization->subjects()->sync($subjectIds);
            DB::commit();

            return $this->successRouteRedirect('admin.specializations.index');
        } catch (Exception $e) {
            DB::rollBack();

            return $this->failRouteRedirect();
        }
    }
}
