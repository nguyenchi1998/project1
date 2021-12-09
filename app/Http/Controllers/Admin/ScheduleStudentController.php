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
        IScheduleRepository $scheduleRepository,
        IScheduleDetailRepository $scheduleDetailRepository,
        ISpecializationRepository $specializationRepository,
        ISubjectRepository $subjectRepository,
        IClassRepository $classRepository,
        IStudentRepository $studentRepository,
        IGradeRepository $gradeRepository
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
        $filterSemester = $request->get('semester-filter');
        $filterGrade = $request->get('grade-filter');
        $keyword = $request->get('keyword');
        $semesters = range_semester(config('config.student_register_start_semester'), config('config.max_semester'));
        $states = array_map(function ($val) {
            return ucfirst($val);
        }, array_flip(config('credit.register')));
        $students = $this->studentRepository->model()
            ->whereHas('class', function ($query) {
                $query->where('semester', '>=', config('config.student_register_start_semester'));
            })
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('phone', $keyword)
                    ->orWhere('email', 'like', '%' . $keyword . '%');
            })
            ->paginate(config('config.paginate'));
        $students->getCollection()->transform(function ($student) {
            $student['total_credit'] = $student->scheduleDetails->filter(function ($scheduleDetail) {
                return $scheduleDetail->status_register == config('schedule.detail.status.register.pending');
            })->reduce(function ($total, $schedule) {
                $total += $schedule->specializationSubject->subject->credit;

                return $total;
            }, 0);

            return $student;
        });
        $grades = $this->gradeRepository->all()->pluck('name', 'id');

        return view('admin.schedule.student.index', compact(
            'students',
            'keyword',
            'filterGrade',
            'states',
            'grades',
            'semesters',
            'filterSemester'
        ));
    }

    public function registerScheduleShow(Request $request, $id)
    {
        $student = $this->studentRepository->find($id);
        $class = $this->classRepository->find($student->class->id);
        $specialization = $this->specializationRepository->find($student->class->specialization_id)
            ->load([
                'subjects' => function ($query) use ($class) {
                    $query->whereType(config('subject.type.specialization'))
                        ->where(function ($query) use ($class) {
                            $query->where('specialization_subject.semester', '>=', $class->semester)
                                ->orWhere('specialization_subject.semester', null);
                        });
                }
            ]);
        $specializationSubjects = $specialization->subjects->sortByDesc('pivot.force')->sortBy('pivot.semester');
        $forceSpecializationSubject = $specializationSubjects->filter(function ($subject) {
            return $subject['force'];
        });
        $scheduleDetails = $student->scheduleDetails->pluck('subject_id')->toArray();
        $totalCreditRegisted = $student->scheduleDetails->map(function ($scheduleDetail) {
            return $scheduleDetail->specializationSubject->subject;
        })
            ->concat($forceSpecializationSubject)
            ->unique('id')
            ->reduce(function ($total, $subject) {
                $total += $subject->credit;

                return $total;
            }, 0);

        return view('admin.schedule.student.create', compact(
            'specializationSubjects',
            'student',
            'scheduleDetails',
            'totalCreditRegisted'
        ));
    }

    public function registerSchedule(Request $request, $id)
    {
        if (!$request->get('subjects') || !count($request->get('subjects'))) {
            return $this->failRouteRedirect();
        }
        $this->scheduleDetailRepository->updateOrCreateMany(
            array_map(function ($item) use ($id) {
                $item['student_id'] = $id;
                $item['register_status'] = config('schedule.detail.status.register.pending');

                return $item;
            }, $request->get('subjects'))
        );

        return $this->successRouteRedirect('admin.schedules.students.registerScheduleShow', $id);
    }

    public function creditStatus(Request $request, $id)
    {
        $this->studentRepository->update($id, $request->only('can_register_credit'));

        return $this->successRouteRedirect('admin.schedules.students.index');
    }
}
