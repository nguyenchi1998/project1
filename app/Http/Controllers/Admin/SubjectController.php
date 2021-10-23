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
        ISubjectRepository        $subjectRepository,
        ISpecializationRepository $specializationRepository,
        IDepartmentRepository     $departmentRepository
    ) {
        $this->subjectRepository = $subjectRepository;
        $this->departmentRepository = $departmentRepository;
        $this->specializationRepository = $specializationRepository;
    }

    public function index(Request $request)
    {
        $filter = $request->get('filter');
        $subjects = $this->subjectRepository->model()
            ->with([
                'department' => function ($query) use ($filter) {
                    $query->when(!$filter || $filter == 'all', function ($query) {
                    }, function ($query) use ($filter) {
                        $query->where('departments.id', $filter);
                    });
                }
            ])
            ->get();
        $subjects = $subjects->map(function ($subject) {
            $specializations = array_map(function ($specialization) {
                return $specialization['name'];
            }, $subject->specializations->toArray());
            $subject['specializations'] = implode(',', $specializations);

            return $subject;
        });
        $departments = $this->departmentRepository->all();

        return view('admin.subject.index', compact('subjects', 'departments', 'filter'));
    }

    public function create()
    {
        $semesters = [];
        for ($i = 1; $i <= config('common.semester.max'); $i++) {
            $semesters[$i] = $i;
        }
        $departments = $this->departmentRepository->all();

        return view('admin.subject.create', compact('departments', 'semesters'));
    }

    public function store(Request $request)
    {
        $this->subjectRepository->create([
            'name' => $request->get('name'),
            'credit' => $request->get('credit'),
            'semester' => $request->get('semester'),
            'type' => $request->get('basic') ? config('common.subject.type.basic') : config('common.subject.type.specialization'),
            'department_id' => $request->get('department_id'),
        ]);

        return redirect()->route('admin.subjects.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $subject = $this->subjectRepository->find($id);
        if ($subject) {
            $subject = $subject->load('specializations');
        }
        $specializations = $this->specializationRepository->all();
        $departments = $this->departmentRepository->all();

        return view('admin.subject.edit', compact('subject', 'specializations', 'departments'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->subjectRepository->update($id, [
                'name' => $request->get('name'),
                'credit' => $request->get('credit'),
                'department_id' => $request->get('department_id'),
            ]);
            $subject = $this->subjectRepository->find($id);
            $subject->specializations()->sync($request->get('specializations'));
            DB::commit();

            return redirect()->route('admin.subjects.index');
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back();
        }

    }

    public function destroy($id)
    {
        //
    }
}
