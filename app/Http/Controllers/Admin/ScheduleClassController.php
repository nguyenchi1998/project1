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
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\CssSelector\Exception\InternalErrorException;

class ScheduleClassController extends Controller
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
        $semesterFilter = $request->get('semester-filter');
        $specalizationFilter = $request->get('specalization-filter');
        $gradeFilter = $request->get('grade-filter');
        $keyword = $request->get('keyword');
        $semesters = array_map(function ($item) {
            return 'Kì ' . $item;
        }, range(config('config.start_semester'),   config('config.max_semester_register_by_class')));
        $classes = $this->classRepository->model()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->when($specalizationFilter, function ($query) use ($specalizationFilter) {
                $query->whereHas('specialization', function ($query)
                use ($specalizationFilter) {
                    $query->whereId($specalizationFilter);
                });
            })
            ->with(['students', 'schedules'])
            ->paginate(config('config.paginate'));
        $classes->getCollection()->transform(function ($class) {
            $class['can_register'] = $class->schedules->reduce(function ($total, $schedule) {
                    $total += $schedule->subject->credit;

                    return $total;
                }, 0) < config('config.max_credit_register');
            return $class;
        });
        $grades = $this->gradeRepository->all()->pluck('name', 'id');
        $specalizations = $this->specializationRepository->all()->pluck('name', 'id');

        return view('admin.schedule.class.index', compact('classes',  'keyword', 'semesterFilter', 'specalizationFilter', 'gradeFilter', 'grades', 'semesters', 'specalizations'));
    }

    public function registerScheduleShow($id)
    {
        $class = $this->classRepository->find($id);
        $basicSubject = $this->subjectRepository->model()
            ->basicSubjects()
            ->get();
        $scheduleSubjects = $this->scheduleRepository->model()
            ->where('class_id', $id)
            ->get()
            ->map(function ($scheduleDetail) {
                return $scheduleDetail->subject->id;
            })->toArray();

        return view('admin.schedule.class.create', compact('basicSubject', 'scheduleSubjects', 'class'));
    }

    public function registerSchedule(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $class = $this->classRepository->find($id);
            $students = $class->students->pluck('id')->toArray();
            $subjects = $this->subjectRepository->whereIn('id', $request->get('subjects'))
                ->get()
                ->map(function ($subject) use ($class) {
                    $item['id'] = $subject->id;
                    $item['class_id'] = $class->id;
                    $item['name'] = 'Lớp Tín Chỉ Môn ' . $subject->name;
                    $item['subject_id'] = $subject->id;

                    return $item;
                })->toArray();
            foreach ($subjects as $subject) {
                $schedule = $this->scheduleRepository->create($subject);
                $this->scheduleDetailRepository->createMany(array_map(function ($student) use ($schedule, $subject) {
                    $item['student_id'] = $student;
                    $item['schedule_id'] = $schedule->id;
                    $item['subject_id'] = $subject['id'];

                    return $item;
                }, $students));
            }
            DB::commit();
        } catch (Exception $exception) {
            throw new InternalErrorException('Error');
        }
    }
}
