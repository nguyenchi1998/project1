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
        $semesters = range_semester(config('config.student_register_start_semester'), config('config.max_semester'));
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
            })->sum(function ($schedule) {
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

    public function registerScheduleShow(Request $request, $id)
    {
        $student = $this->studentRepository->find($id)->load('scheduleDetails.subject');
        $class = $this->classRepository->find($student->class->id);
        $semesterFilter = $request->get('semester-filter', $class->semester);
        $semesters = range_semester(
            config('config.start_semester'),
            config('config.max_semester'),
            true,
            $class->semester,
            true
        );
        $subjects = $this->specializationSubjectRepository->model()
            ->where('specialization_subject.specialization_id', $student->class->specialization_id)
            ->whereHas('subject', function ($query) {
                $query->whereType(config('subject.type.specialization'));
            })
            ->when($semesterFilter < $class->semester, function ($query) use ($semesterFilter) {
                $query->where('specialization_subject.semester', $semesterFilter);
            }, function ($query) use ($class, $semesterFilter) {
                $query->where(function ($query) use ($class, $semesterFilter) {
                    $query->whereBetween('specialization_subject.semester', [$semesterFilter, $class->semester])
                        ->orWhere('specialization_subject.semester', null);
                });
            })
            ->with('subject')
            ->select('specialization_subject.*', 'schedule_details.id as isSelected')
            ->leftJoin('schedule_details', function ($join) use ($student) {
                $join->on('specialization_subject.subject_id', '=', 'schedule_details.subject_id')
                    ->where('student_id', $student->id)
                    ->join('subjects', 'schedule_details.subject_id', '=', 'subjects.id');
            })
            ->get();
        $totalCreditRegisted = $subjects->filter(function ($subject) {
            return $subject->isSelected;
        })->sum(function ($subject) {
            return $subject->subject->credit;
        });

        return view('admin.schedule.student.create', compact(
            'subjects',
            'student',
            'totalCreditRegisted',
            'semesters',
            'semesterFilter'
        ));
    }

    public function registerSchedule(RegisterCreditStudent $request, $id)
    {
        $this->scheduleDetailRepository->updateOrCreateMany(
            array_map(function ($item) use ($id) {
                $item['student_id'] = $id;
                $item['register_status'] = config('schedule.detail.status.register.pending');

                return $item;
            }, $request->get('subjects'))
        );
    }

    public function creditStatus(Request $request, $id)
    {
        $this->studentRepository->update($id, $request->only('can_register_credit'));

        return $this->successRouteRedirect('admin.schedules.students.index');
    }
}
