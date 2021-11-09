<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\IClassRepository;
use App\Repositories\IGradeRepository;
use App\Repositories\IScheduleDetailRepository;
use App\Repositories\IScheduleRepository;
use App\Repositories\ISpecializationRepository;
use App\Repositories\IStudentRepository;
use App\Repositories\ISubjectRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScheduleStudentController extends Controller
{
    protected $scheduleRepository;
    protected $scheduleDetailRepository;
    protected $specializationRepository;
    protected $subjectRepository;
    protected $classRepository;
    protected $studentRepository;
    protected $gradeRepository;

    public function __construct(
        IScheduleRepository       $scheduleRepository,
        IScheduleDetailRepository $scheduleDetailRepository,
        ISpecializationRepository $specializationRepository,
        ISubjectRepository        $subjectRepository,
        IClassRepository          $classRepository,
        IStudentRepository        $studentRepository,
        IGradeRepository          $gradeRepository
    ) {
        $this->scheduleRepository = $scheduleRepository;
        $this->specializationRepository = $specializationRepository;
        $this->subjectRepository = $subjectRepository;
        $this->classRepository = $classRepository;
        $this->studentRepository = $studentRepository;
        $this->gradeRepository = $gradeRepository;
        $this->scheduleDetailRepository = $scheduleDetailRepository;
    }

    public function index(Request $request)
    {
        $filterGrade = $request->get('semester-filter');
        $filterGrade = $request->get('grade-filter');
        $keyword = $request->get('keyword');
        $semesters = array_map(function ($item) {
            return 'Kì ' . $item;
        }, range(config('config.max_semester_register_by_class') + 1, config('config.max_semester')));
        // lấy ra danh sách sinh viên từ kì 5 (năm 3)
        $students = $this->studentRepository->model()
            ->whereHas('class', function ($query) {
                $query->where('semester', '>', config('config.max_semester_register_by_class'));
            })
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('phone', $keyword)
                    ->orWhere('email', 'like', '%' . $keyword . '%');
            })
            ->paginate(config('config.paginate'));
        $students->getCollection()->transform(function ($student) {
            $student['total_credit'] = $student->scheduleDetails->reduce(function ($total, $schedule) {
                $total += $schedule->subject->credit;

                return $total;
            }, 0);
            return $student;
        });
        $grades = $this->gradeRepository->all()->pluck('name', 'id');

        return view('admin.schedule.student.index', compact('students', 'keyword', 'filterGrade', 'grades', 'semesters'));
    }

    public function registerScheduleShow(Request $request, $id)
    {
        $student = $this->studentRepository->find($id);
        $class = $this->classRepository->find($student->class->id);
        // lấy danh sách môn học chuyên ngành có kì học lớn hơn kì học của lớp và các môn ko có kì học cụ thê
        $specialization = $this->specializationRepository->find($student->class->specialization_id)
            ->load([
                'subjects' => function ($query) use ($class) {
                    $query->whereType(config('config.subject.type.specialization'))
                        ->where(function ($query) use ($class) {
                            $query->where('specialization_subject.semester', '>=', $class->semester)
                                ->orWhere('specialization_subject.semester', null);
                        });
                },
                'subjects.schedules' => function ($query) {
                    $query->where('status', config('config.status.schedule.new'))
                        ->where('class_id', null);
                }
            ]);
        // danh sách môn học thuộc kì hiện tại và bắt buộc
        $specializationSubjects = $specialization->subjects->map(function ($subject) use ($class) {
            $subject['force'] = $subject->pivot->force && $subject->pivot->semester == $class->semester;
            $creditClass = $subject->schedules->first();
            $subject['creditClass'] = $creditClass ? $creditClass->load('scheduleDetails')->toArray() : [];

            return $subject;
        });
        // lấy danh sách các môn chuyên ngành bắt buộc
        $forceSpecializationSubject = $specializationSubjects->filter(function ($subject) {
            return $subject['force'];
        });
        $scheduleDetails = $student->scheduleDetails->pluck('subject_id')->toArray();
        $totalCreditRegisted = $student->scheduleDetails->map(function ($scheduleDetail) {
            return $scheduleDetail->subject;
        })
            ->concat($forceSpecializationSubject)
            ->unique('id')
            ->reduce(function ($total, $subject) {
                return $total += $subject->credit;
            }, 0);

        return view('admin.schedule.student.create', compact('specializationSubjects', 'student', 'scheduleDetails', 'totalCreditRegisted'));
    }

    public function registerSchedule(Request $request, $id)
    {
        if (!$request->get('subjects') || !count($request->get('subjects'))) {
            return $this->failRouteRedirect();
        }
        $this->scheduleDetailRepository->updateOrCreateMany(
            array_map(function ($item) use ($id) {
                $item['student_id'] = $id;
                return $item;
            },  $request->get('subjects'))
        );

        return $this->successRouteRedirect('admin.schedules.students.registerScheduleShow', $id);
    }

    public function registerCreditStatus(Request $request)
    {
        if ($request->id) {
            $this->studentRepository->update($request->id, $request->only('can_register_credit'));
        } else {
            $this->studentRepository->model()
                ->query()
                ->update($request->only('can_register_credit'));
        }

        return $this->successRouteRedirect('admin.schedules.students.index');
    }
}
