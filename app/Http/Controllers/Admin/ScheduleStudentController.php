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
        IScheduleRepository       $scheduleRepository,
        IScheduleDetailRepository $scheduleDetailRepository,
        ISpecializationRepository $specializationRepository,
        ISubjectRepository        $subjectRepository,
        IClassRepository          $classRepository,
        IStudentRepository        $studentRepository,
        IGradeRepository          $gradeRepository
    )
    {
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
        $filterGrade = $request->get('grade-filter');
        $keyword = $request->get('keyword');
        $semesters = array_map(function ($item) {
            return 'Kỳ ' . $item;
        }, range(config('config.max_semester_register_by_class') + 1, config('config.max_semester')));
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
        $grades = $this->gradeRepository->all()->pluck('name', 'id');

        return view('admin.schedule.student.index', compact('students', 'keyword', 'filterGrade', 'grades', 'semesters'));
    }

    public function registerScheduleShow(Request $request, $id)
    {
        $student = $this->studentRepository->find($id)
            ->load(['class.specialization', 'class.specialization.subjects' => function ($query) {
                $query->where('type', '!=', config('config.subject.type.basic'));
            }, 'scheduleDetails']);
        $specializationSubjects = $student->class->specialization->subjects;
        $scheduleDetails = $student->scheduleDetails->pluck('subject_id')->toArray();

        return view('admin.schedule.student.create', compact('specializationSubjects', 'student', 'scheduleDetails'));
    }

    public function registerSchedule(Request $request, $id)
    {
        $this->scheduleDetailRepository->updateOrCreateMany($request->get('subjects'));

        return redirect()->route('admin.schedules.credits.students.registerScheduleShow', $id)
            ->with('success', 'Đăng ký tín chỉ thành công cho sinh viên');
    }
}
