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
            ->get();
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

    public function show(Request $request, $classId)
    {
        $class = $this->classRepository->find($classId);
        $semesterFilter = $request->get('semester-filter', $class->semester);
        $specializationFilter = $request->get('specialization-filter');
        $keyword = $request->get('keyword');
        $semesters = range_semester(
            config('config.start_semester'),
            config('config.class_register_limit_semester'),
            true,
            $class->semester
        );
        $schedules = $this->scheduleRepository->model()
            ->where('class_id', $classId)
            ->when($semesterFilter, function ($query) use ($semesterFilter) {
                $query->where('semester', $semesterFilter);
            })
            ->with(['subject.specializations'])
            ->orderBy('status')
            ->get();

        return view('admin.schedule.class.list_credit', compact(
            'schedules',
            'keyword',
            'semesterFilter',
            'specializationFilter',
            'semesters',
            'class',
        ));
    }

    public function create($classId)
    {
        $class = $this->classRepository->find($classId);
        $subjects = $this->subjectRepository->model()
            ->where('semester', $class->semester)
            ->get();
        $classSubjects = $this->scheduleRepository->model()
            ->where('class_id', $classId)
            ->where('semester', $class->semester)
            ->with('subject')
            ->get();
        $totalRegisterSubjects = $classSubjects->sum(function ($classSubject) {
            return $classSubject->subject->credit;
        });
        $classSubjectIds = $classSubjects->pluck('subject_id')
            ->toArray();

        return view('admin.schedule.class.create', compact(
            'subjects',
            'class',
            'classSubjectIds',
            'totalRegisterSubjects'
        ));
    }

    public function store(Request $request, $classId)
    {
        try {
            DB::beginTransaction();
            $class = $this->classRepository->findOrFail($classId);
            $subjects = $this->subjectRepository->whereIn(
                'id',
                $request->get('subjectIds')
            )->get()->map(function ($subject) use ($class) {
                $item['class_id'] = $class->id;
                $item['subject_id'] = $subject->id;
                $item['semester'] = $class->semester;
                $item['credit'] = $subject->credit;

                return $item;
            })->toArray();
            foreach ($subjects as $subject) {
                $this->scheduleRepository->model()->updateOrCreate($subject);
            }
            DB::commit();

            return $this->successRouteRedirect();
        } catch (Exception $e) {
            return $this->failRouteRedirect($e->getMessage());
        }
    }

    public function destroy(Request $request, $classId, $scheduleId)
    {
        $this->scheduleRepository->delete($scheduleId);

        return $this->successRouteRedirect();
    }
}
