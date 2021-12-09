<?php

namespace App\Http\Controllers;

use App\Repositories\IClassRepository;
use App\Repositories\IScheduleDetailRepository;
use App\Repositories\ISpecializationRepository;
use App\Repositories\ISubjectRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreditController extends Controller
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
        $semester = range_semester(config('config.start_semester'), $class->specialization->max_semester);
        $credits = $this->scheduleDetailRepository->where('student_id', '=', $student->id)
            ->where('register_status', config('schedule_detail.status.register.pending'))
            ->get()
            ->load(['subject', 'schedule']);

        return view('student.credit.index', compact('credits', 'semester', 'semesterFilter'));
    }

    public function create(Request $request)
    {
        $student = Auth::user();
        $class = $this->classRepository->find($student->class_id)
            ->load('specialization');
        $specialization = $this->specializationRepository->find($student->class->specialization_id)
            ->load([
                'subjects' => function ($query) use ($class) {
                    $query->whereType(config('subject.type.specialization'))
                        ->where(function ($query) use ($class) {
                            $query->where('specialization_subject.semester', '>=', $class->semester)
                                ->orWhere('specialization_subject.semester', null);
                        })
                        ->orderBy('specialization_subject.semester', 'desc');
                },
                'subjects.schedules' => function ($query) {
                    $query->where('status', config('schedule.status.new'))
                        ->where('class_id', null);
                }
            ]);
        // danh sách môn học thuộc kỳ hiện tại và bắt buộc
        $subjects = $specialization->subjects->map(function ($subject) use ($class) {
            $subject['force'] = $subject->pivot->force && $subject->pivot->semester == $class->semester;

            return $subject;
        });
        $scheduleDetails = $student->scheduleDetails->pluck('subject_id')->toArray();
        $filter = $request->get('filter');

        return view('student.credit.create', compact('filter', 'student', 'subjects', 'scheduleDetails'));
    }

    public function store(Request $request)
    {
        $student = Auth::user();
        $subjectIds = $request->get('subject_id');
        $scheduleDetails = array_map(function ($subject) use ($student) {
            return ['subject_id' => $subject, 'student_id' => $student->id];
        }, $subjectIds);
        $this->scheduleDetailRepository->createMany($scheduleDetails);
        return redirect()->route('credits.index');
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
        $this->scheduleDetailRepository->delete($id, true);

        return $this->successRouteRedirect('credits.index');
    }
}
