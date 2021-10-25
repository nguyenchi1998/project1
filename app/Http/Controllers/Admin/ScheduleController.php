<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\IClassRepository;
use App\Repositories\IScheduleRepository;
use App\Repositories\ISpecializationRepository;
use App\Repositories\IStudentRepository;
use App\Repositories\ISubjectRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    const MAX_SEMESTER_REGISTER_BY_CLASS = 4;

    protected $scheduleRepository;
    protected $specializationRepository;
    protected $subjectRepository;
    protected $classRepository;
    protected $studentRepository;

    public function __construct(
        IScheduleRepository       $scheduleRepository,
        ISpecializationRepository $specializationRepository,
        ISubjectRepository        $subjectRepository,
        IClassRepository          $classRepository,
        IStudentRepository        $studentRepository
    ) {
        $this->scheduleRepository = $scheduleRepository;
        $this->specializationRepository = $specializationRepository;
        $this->subjectRepository = $subjectRepository;
        $this->classRepository = $classRepository;
        $this->studentRepository = $studentRepository;
    }

    public function index(Request $request)
    {
        $semesters = array_map(function ($item) {
            return 'Kỳ ' . $item . ' - Năm ' . ($item <= 2 ? 1 : 2);
        }, range(1, config('config.max_semester_register_by_class')));
        $semester = $request->get('semester');
        $classId = $request->get('class');
        $schedules = $this->scheduleRepository->all()
            ->load('subject', 'teacher', 'scheduleDetails');
        $allClasses = $this->classRepository->where('semester', '<=', config('config.max_semester_register_by_class'))
            ->when($semester, function ($query) use ($semester) {
                $query->where('semester', $semester);
            })
            ->get()
            ->load('specialization.subjects');
        $basicSubjects = $this->subjectRepository->model()
            ->basicSubjects()
            ->get();
        $scheduleClass = $this
            ->scheduleRepository->where('class_id', '!=', null)
            ->get()
            ->load('subject');
        $allClasses = $allClasses->map(function ($class) use ($scheduleClass, $basicSubjects) {
            $subjects = $scheduleClass->where('class_id', $class->id)->all();
            $specializationSubjects = $basicSubjects->diff($subjects);
            $class['unCreditSubjects'] = $specializationSubjects;
            return $class;
        });

        return view('admin.schedule.class.index', compact('allClasses', 'basicSubjects', 'semester', 'semesters'));
    }

    public function registerScheduleShow(Request $request, $id)
    {
        $class = $this->classRepository->find($id)
            ->load('specialization');
        $basicSubjects = $this->subjectRepository->model()
            ->basicSubjects()
            ->get()
            ->load('teachers');
        $schedules = $this->scheduleRepository->where('class_id', '=', $id)
            ->get()
            ->load('subject');
        $scheduleSubjects = $schedules->map(function ($schedule) {
            return $schedule->subject;
        });
        $unCreditSubjects = $basicSubjects->diff($scheduleSubjects);

        return view('admin.schedule.class.create', compact('unCreditSubjects', 'id', 'class'));
    }

    public function registerSchedule(Request $request, $id)
    {
        try {
            $subject = $this->subjectRepository->find($request->get('subject_id'));
            $this->scheduleRepository->create([
                'name' => '[Class] ' . $subject->name,
                'class_id' => $id,
                'subject_id' => $request->get('subject_id'),
                'start_time' => $request->get('start_time'),
            ]);
            $schedule = $this->scheduleRepository->model()
                ->where([
                    'class_id' => $id,
                    'subject_id' => $request->get('subject_id'),
                ])
                ->first();
            $class = $this->classRepository->find($id)
                ->load('students');
            $students = $class->students->map(function ($student) use ($schedule, $request) {
                return [
                    'schedule_id' => $schedule->id,
                    'student_id' => $student->id,
                    'subject_id' => $request->get('subject_id'),
                ];
            });
            $schedule->scheduleDetails()->createMany($students);

            return redirect()->route('admin.schedules.registerShow', $id)
                ->with('success', 'Đăng ký tín chỉ thành công môn "' . $subject->name . '" cho lớp' . $class->name);
        } catch (Exception $e) {
            DB::rollBack();

            return back()->withErrors(['msg' => $e->getMessage()]);
        }
    }
}
