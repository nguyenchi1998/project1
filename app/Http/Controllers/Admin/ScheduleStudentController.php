<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RegisterCreditStudent;
use App\Repositories\IClassRepository;
use App\Repositories\IGradeRepository;
use App\Repositories\IScheduleDetailRepository;
use App\Repositories\IScheduleRepository;
use App\Repositories\ISpecializationRepository;
use App\Repositories\ISpecializationSubjectRepository;
use App\Repositories\IStudentRepository;
use App\Repositories\ISubjectRepository;
use Exception;
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
    protected $specializationSubjectRepository;

    public function __construct(
        IScheduleRepository $scheduleRepository,
        IScheduleDetailRepository $scheduleDetailRepository,
        ISpecializationRepository $specializationRepository,
        ISubjectRepository $subjectRepository,
        IClassRepository $classRepository,
        IStudentRepository $studentRepository,
        IGradeRepository $gradeRepository,
        ISpecializationSubjectRepository $specializationSubjectRepository
    ) {
        $this->scheduleRepository = $scheduleRepository;
        $this->specializationRepository = $specializationRepository;
        $this->subjectRepository = $subjectRepository;
        $this->classRepository = $classRepository;
        $this->studentRepository = $studentRepository;
        $this->gradeRepository = $gradeRepository;
        $this->scheduleDetailRepository = $scheduleDetailRepository;
        $this->specializationSubjectRepository = $specializationSubjectRepository;
    }

    public function index(Request $request)
    {
        $filterSemester = $request->get('semester-filter');
        $filterGrade = $request->get('grade-filter');
        $keyword = $request->get('keyword');
        $semesters = range_semester(
            config('config.student_register_start_semester'),
            config('config.max_semester')
        );
        $students = $this->studentRepository->model()
            ->when($filterSemester, function ($query) use ($filterSemester) {
                $query->whereHas('class', function ($query) use ($filterSemester) {
                    $query->where('semester', $filterSemester);
                });
            })
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('phone', $keyword)
                    ->orWhere('email', 'like', '%' . $keyword . '%');
            })
            ->paginate(config('config.paginate'));
        $students->getCollection()->transform(function ($student) {
            $student->total_credit = $student->scheduleDetails
                ->filter(function ($scheduleDetail) {
                    return $scheduleDetail->status_register == config('schedule.detail.status.register.pending');
                })
                ->sum(function ($schedule) {
                    return $schedule->subject->credit;
                });

            return $student;
        });
        $grades = $this->gradeRepository->all()->pluck('name', 'id');

        return view('admin.schedule.student.index', compact(
            'students',
            'keyword',
            'filterGrade',
            'grades',
            'semesters',
            'filterSemester'
        ));
    }

    public function show(Request $request, $studentId)
    {
        $student = $this->studentRepository
            ->find($studentId);
        $class = $this->classRepository
            ->find($student->class_id);
        $semesterFilter = $request->get(
            'semester-filter',
            $class->semester
        );
        $specializationFilter = $request->get('specialization-filter');
        $keyword = $request->get('keyword');
        $semesters = range_semester(
            config('config.student_register_start_semester'),
            config('config.max_semester'),
            true,
            $class->semester
        );
        $scheduleDetails = $this->scheduleDetailRepository
            ->model()
            ->where('student_id', $student->id)
            ->when(
                $semesterFilter,
                function ($query) use ($semesterFilter) {
                    $query->where('semester', $semesterFilter);
                }
            )
            ->with(['subject', 'schedule'])
            ->orderBy('register_status')
            ->paginate(config('config.paginate'));

        return view('admin.schedule.student.list_credit', compact(
            'scheduleDetails',
            'keyword',
            'semesterFilter',
            'specializationFilter',
            'semesters',
            'student',
            'class'
        ));
    }

    public function create(Request $request, $id)
    {
        $student = $this->studentRepository->find($id)
            ->load('scheduleDetails.subject');
        $class = $this->classRepository->find($student->class->id);
        $studentRegisterSubjects = $this->scheduleDetailRepository
            ->model()
            ->where('student_id', $student->id)
            ->where('semester', $class->semester)
            ->with('subject')
            ->get();
        $studentRegisterSubjectIds = $studentRegisterSubjects
            ->pluck('subject.id')
            ->toArray();
        $subjects = $this->subjectRepository->model()
            ->where('semester', $class->semester)
            ->whereNotIn('id', $studentRegisterSubjectIds)
            ->get()
            ->load('newSchedules')
            ->map(function ($subject) {
                $subject->hasClass = count($subject->newSchedules);

                return $subject;
            });
        $totalCreditRegisted = $studentRegisterSubjects->sum(function ($studentRegisterSubject) {
            return $studentRegisterSubject->subject->credit;
        });

        return view('admin.schedule.student.create', compact(
            'student',
            'studentRegisterSubjects',
            'studentRegisterSubjectIds',
            'totalCreditRegisted',
            'subjects'
        ));
    }

    public function store(RegisterCreditStudent $request, $studentId)
    {
        $student = $this->studentRepository->find($studentId)
            ->load('class');
        $this->scheduleDetailRepository->updateOrCreateMany(
            array_map(function ($subjectId) use ($studentId, $student) {
                $item['student_id'] = $studentId;
                $item['register_status'] = config('schedule.detail.status.register.pending');
                $item['subject_id'] = $subjectId;
                $item['specialization_id'] = $student->class->specialization_id;
                $item['semester'] = $student->class->semester;

                return $item;
            }, $request->get('subjectIds'))
        );

        return $this->successRouteRedirect('admin.schedules.students.show', $studentId);
    }

    public function destroy($studentId, $scheduleDetailId)
    {
        $this->scheduleDetailRepository->delete($scheduleDetailId, true);

        return $this->successRouteRedirect('admin.schedules.students.show', $studentId);
    }

    public function creditStatus(Request $request, $id)
    {
        $this->studentRepository->update($id, $request->only('can_register_credit'));

        return $this->successRouteRedirect('admin.schedules.students.index');
    }
}
