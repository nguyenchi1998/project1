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
        IScheduleRepository $scheduleRepository,
        IScheduleDetailRepository $scheduleDetailRepository,
        ISpecializationRepository $specializationRepository,
        ISubjectRepository $subjectRepository,
        IClassRepository $classRepository,
        IStudentRepository $studentRepository,
        IGradeRepository  $gradeRepository
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
        $semesterFilter = $request->get('semester-filter');
        $specializationFilter = $request->get('specialization-filter');
        $keyword = $request->get('keyword');
        $semesters = range_semester(config('config.start_semester'), config('config.class_register_limit_semester'));
        $classes = $this->classRepository->model()
            ->newbieClass()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->when($specializationFilter, function ($query) use ($specializationFilter) {
                $query->whereHas('specialization', function ($query) use ($specializationFilter) {
                    $query->whereId($specializationFilter);
                });
            })
            ->with(['students', 'schedules'])
            ->paginate(config('config.paginate'));
        $specializations = $this->specializationRepository->all()
            ->pluck('name', 'id');

        return view('admin.schedule.class.index', compact(
            'classes',
            'keyword',
            'semesterFilter',
            'specializationFilter',
            'semesters',
            'specializations'
        ));
    }

    public function showListCredits(Request $request, $classId)
    {
        $class = $this->classRepository->find($classId);
        $semesterFilter = $request->get('semester-filter');
        $specializationFilter = $request->get('specialization-filter');
        $keyword = $request->get('keyword');
        $semesters = range_semester(config('config.start_semester'), config('config.class_register_limit_semester'), true, $class->semester);
        $schedules = $this->scheduleRepository->model()
            ->where('class_id', $classId)
            ->when($semesterFilter, function ($query) use ($semesterFilter) {
                $query->whereHas('specializationSubject', function ($query) use ($semesterFilter) {
                    $query->where('semester', $semesterFilter);
                });
            })
            ->with(['specializationSubject.subject.specializations'])
            ->orderBy('status')
            ->paginate(config('config.paginate'));
        return view('admin.schedule.class.list_credit', compact(
            'schedules',
            'keyword',
            'semesterFilter',
            'specializationFilter',
            'semesters',
            'class'
        ));
    }

    public function registerScheduleShow($classId)
    {
        $class = $this->classRepository->find($classId);
        $specialization = $this->specializationRepository->find($class->specialization_id)
            ->load(['subjects' => function ($query) use ($class) {
                $query->whereType(config('subject.type.basic'))
                    ->wherePivot('semester', $class->semester + 1);
            }]);
        // lấy danh sách môn học cơ bản thuộc kỳ tiếp theo của lớp
        $basicSubjects = $specialization->subjects;

        // danh sách các môn đã đăng kí của lớp ở kỳ tiếp theo của lớp
        $scheduleSubjects = $this->scheduleRepository->model()
            ->where('class_id', $classId)
            ->whereHas('specializationSubject', function ($query) use ($class) {
                $query->whereSemester($class->semester + 1);
            })
            ->with(['specializationSubject.subject.specializations' => function ($query) use ($class) {
                $query->where('specializations.id', $class->specialization->id);
            }])
            ->get()
            ->pluck('id', 'subject_id')
            ->toArray();

        return view('admin.schedule.class.create', compact('basicSubjects', 'scheduleSubjects', 'class'));
    }

    /**
     * @throws InternalErrorException
     */
    public function registerSchedule(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $class = $this->classRepository->find($id);
            $subjects = $this->subjectRepository->whereIn('id', array_column($request->get('subjects'), 'subject_id'))
                ->get()
                ->map(function ($subject) use ($class) {
                    $item['class_id'] = $class->id;
                    $item['name'] = 'Lớp Tín Chỉ Môn ' . $subject->name;
                    $item['subject_id'] = $subject->id;

                    return $item;
                })->toArray();
            foreach ($subjects as $subject) {
                $this->scheduleRepository->model()->updateOrCreate($subject);
            }
            DB::commit();
        } catch (Exception $exception) {
            throw new InternalErrorException('Error');
        }
    }
}
