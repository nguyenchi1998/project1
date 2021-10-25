<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\IClassRepository;
use App\Repositories\IScheduleRepository;
use App\Repositories\ISpecializationRepository;
use App\Repositories\IStudentRepository;
use App\Repositories\ISubjectRepository;
use Illuminate\Http\Request;

class ScheduleStudentController extends Controller
{
    const MAX_SEMESTER_GROUP_BY_CLASS = 2;
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
        $filterClass = $request->get('filter_class');
        $keyword = $request->get('keyword');
        $students = $this->studentRepository->model()
            ->whereHas('class', function ($query) use ($filterClass) {
                $query->where('semester', ' > ', self::MAX_SEMESTER_GROUP_BY_CLASS)
                    ->when($filterClass && $filterClass != 'all', function ($query) use ($filterClass) {
                        $query->whereId($filterClass);
                    });
            })
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('phone', $keyword)
                    ->orWhere('email', 'like', '%' . $keyword . '%');
            })
            ->paginate(config('common.paginate'));
        $classes = $this->classRepository->all();

        return view('admin.schedule.student.index', compact('students', 'keyword', 'filterClass', 'classes'));
    }

    public function registerScheduleShow(Request $request, $id)
    {
        $class = $this->classRepository->find($id)
            ->load('specialization');
        $basicSubjects = $this->subjectRepository->model()
            ->basicSubjects()
            ->get()
            ->load('teachers');
        $schedules = $this->scheduleRepository->where('class_id', ' = ', $id)
            ->get()->load('subject');
        $scheduleSubjects = $schedules->map(function ($schedule) {
            return $schedule->subject;
        });
        $unCreditSubjects = $basicSubjects->diff($scheduleSubjects);

        return view('admin . schedule .class.create', compact('unCreditSubjects', 'id', 'class'));
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
            $class = $this->classRepository->find($id)->load('students');
            $students = $class->students->map(function ($student) use ($schedule, $request) {
                return [
                    'schedule_id' => $schedule->id,
                    'student_id' => $student->id,
                    'subject_id' => $request->get('subject_id'),
                ];
            });
            $schedule->scheduleDetails()->createMany($students);

            return redirect()->route('admin . schedules . registerShow', $id)
                ->with('success', 'Đăng ký tín chỉ thành công môn "' . $subject->name . '" cho lớp' . $class->name);
        } catch (Exception $e) {
            DB::rollBack();

            return back()->withErrors(['msg' => $e->getMessage()]);
        }
    }
}
