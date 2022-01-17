<?php

namespace App\Http\Controllers;

use App\Repositories\IClassRepository;
use App\Repositories\IScheduleDetailRepository;
use App\Repositories\ISpecializationRepository;
use App\Repositories\ISubjectRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    protected $scheduleDetailRepository;
    protected $specializationRepository;
    protected $classRepository;
    protected $subjectRepository;

    public function __construct(
        IScheduleDetailRepository $scheduleDetailRepository,
        ISpecializationRepository $specializationRepository,
        IClassRepository $classRepository,
        ISubjectRepository $subjectRepository
    ) {
        $this->scheduleDetailRepository = $scheduleDetailRepository;
        $this->classRepository = $classRepository;
        $this->subjectRepository = $subjectRepository;
        $this->specializationRepository = $specializationRepository;
    }

    public function index(Request $request)
    {
        $student = Auth::user();
        $class = $this->classRepository->find($student->class_id);
        $semesterFilter = $request->get('semester', $class->semester);
        $semester = range_semester(config('config.start_semester'), config('config.max_semester'), true, $class->semester);
        $scheduleDetails = $this->scheduleDetailRepository->model()
            ->where('student_id', $student->id)
            ->when($semesterFilter, function ($query) use ($semesterFilter) {
                $query->where('semester', $semesterFilter);
            })
            ->with(['subject', 'schedule'])
            ->orderBy('register_status')
            ->paginate(config('config.paginate'));

        return view('student.credit.index', compact('scheduleDetails', 'semester', 'semesterFilter', 'class'));
    }

    public function create(Request $request)
    {
        $student = Auth::user();
        $class = $this->classRepository->find($student->class->id);
        $studentRegisterSubjects = $this->scheduleDetailRepository->model()
            ->where('student_id', $student->id)
            ->where('semester', $class->semester)
            ->with('subject')
            ->get();
        $studentRegisterSubjectIds = $studentRegisterSubjects->pluck('subject.id')->toArray();
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


        return view('student.credit.create', compact('student', 'subjects'));
    }

    public function store(Request $request)
    {
        $student = Auth::user();
        $class = $this->classRepository->find($student->class_id);
        $this->scheduleDetailRepository->updateOrCreateMany(
            array_map(function ($subjectId) use ($student, $class) {
                $item['student_id'] = $student->id;
                $item['register_status'] = config('schedule.detail.status.register.pending');
                $item['subject_id'] = $subjectId;
                $item['specialization_id'] = $class->specialization_id;
                $item['semester'] = $class->semester;

                return $item;
            }, $request->get('subjectIds'))
        );

        return $this->successRouteRedirect('scheduleDetails.credits.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $result = $this->scheduleDetailRepository->delete($id, true);
        if ($result) {
            return $this->successRouteRedirect();
        }

        return $this->failRouteRedirect();
    }
}
