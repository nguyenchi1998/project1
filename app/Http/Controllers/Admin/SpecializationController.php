<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChooseSubject;
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
        $departmentFilter = $request->get('department-filter');
        $specializations = $this->specializationRepository->withTrashedModel()
            ->when($departmentFilter, function ($query) use ($departmentFilter) {
                $query->whereHas('department', function ($query) use ($departmentFilter) {
                    $query->where('id', $departmentFilter);
                });
            })
            ->with(['subjects', 'department'])
            ->paginate(config('config.paginate'));
        $departments = $this->departmentRepository->all()->pluck('name', 'id')->toArray();

        return view('admin.specialization.index', compact(
            'specializations',
            'keyword',
            'departmentFilter',
            'departments'
        ));
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
            $specialization = $this->specializationRepository->create($request->only([
                'name',
                'min_credit',
                'department_id',
            ]));
            $basicSubjectIds = $this->subjectRepository->model()
                ->basicSubjects()
                ->get()
                ->reduce(function ($subjects, $subject) {
                    $subjects[$subject->id] = [
                        'semester' => $subject->semester,
                        'force' => config('subject.force'),
                    ];

                    return $subjects;
                }, []);
            $specialization->subjects()->sync($basicSubjectIds);
            DB::commit();

            return $this->successRouteRedirect('admin.specializations.index');
        } catch (Exception $e) {
            DB::rollBack();

            return $this->failRouteRedirect($e->getMessage());
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
            ]));
            DB::commit();

            return $this->successRouteRedirect('admin.specializations.index');
        } catch (Exception $e) {
            DB::rollBack();

            return $this->failRouteRedirect($e->getMessage());
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
        $specialization = $this->specializationRepository->find($id)
            ->load('subjects');
        $specializationSubjects = $specialization->subjects->pluck('id')->toArray();
        $startSemester = config('config.start_semester');
        $basicSemesters =  range_semester(
            config('config.start_semester'),
            config('config.class_register_limit_semester')
        );
        $specializationSemesters =  range_semester(
            config('config.student_register_start_semester'),
            config('config.max_semester')
        );
        $subjects = $this->subjectRepository->allWithTrashed();
        $subjects = $subjects->map(function ($subject) use ($specialization) {
            $subject->choose = $specialization->subjects->contains($subject->id);
            $subject->semester = $specialization->subjects->first(
                function ($subjectItem) use ($subject, $specialization) {
                    return $specialization->subjects->contains('id', $subject->id)
                        && $subjectItem->id == $subject->id;
                }
            )->pivot->semester ?? null;

            return $subject;
        })
            ->sortBy('type');

        return view('admin.specialization.choose_subject', compact(
            'specialization',
            'subjects',
            'specializationSubjects',
            'basicSemesters',
            'specializationSemesters'
        ));
    }

    public function chooseSubject(ChooseSubject $request, $id)
    {
        try {
            DB::beginTransaction();
            $basicSubjectIds = $this->subjectRepository->model()
                ->basicSubjects()
                ->get()
                ->pluck('id')
                ->toArray();
            $subjectDatas = $request->get('subjects');
            $subjectIds = array_keys($subjectDatas);
            $diffSubjectIds = array_diff($basicSubjectIds, $subjectIds);
            if ($diffSubjectIds) {
                return response([
                    'status' => false,
                    'message' => 'Các Môn Đại Cương Chưa Chọn Đủ'
                ]);
            }
            $subjectDatas = array_map(function ($subject) {
                $subject['force'] = (bool) $subject['force'];

                return $subject;
            }, $subjectDatas);
            $specialization = $this->specializationRepository->find($id);
            $specialization->subjects()->sync($subjectDatas);
            DB::commit();

            return response([
                'status' => true,
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            return response([
                'status' => false,
                'message' => 'Xử lý thất bại ('  . $e->getMessage() . ')',
            ]);
        }
    }
}
