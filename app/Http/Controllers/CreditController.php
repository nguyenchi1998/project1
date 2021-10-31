<?php

namespace App\Http\Controllers;

use App\Repositories\IClassRepository;
use App\Repositories\IScheduleDetailRepository;
use App\Repositories\ISubjectRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreditController extends Controller
{
    protected $scheduleDetailRepository;
    protected $classRepository;
    protected $subjectRepository;

    public function __construct(
        IScheduleDetailRepository $scheduleDetailRepository,
        IClassRepository          $classRepository,
        ISubjectRepository        $subjectRepository
    )
    {
        $this->scheduleDetailRepository = $scheduleDetailRepository;
        $this->classRepository = $classRepository;
        $this->subjectRepository = $subjectRepository;
    }

    public function index(Request $request)
    {
        $semesterFilter = $request->semester;
        $student = Auth::user();
        $class = $this->classRepository->find($student->class_id);
        $semester = array_map(function ($item) {
            return 'Kỳ ' . $item;
        }, range(config('config.start_semester'), $class->specialization->total_semester));
        $credits = $this->scheduleDetailRepository->where('student_id', '=', $student->id)
            ->where('status', '=', null)
            ->get();
        if ($credits) {
            $credits->load(['subject', 'schedule']);
        }

        return view('credit.index', compact('credits', 'semester', 'semesterFilter'));
    }

    public function create(Request $request)
    {
        $student = Auth::user();
        $class = $this->classRepository->find($student->class_id)
            ->load('specialization');
        $subjects = $this->subjectRepository->model()
            ->specializationSubjects()
            ->whereHas('specializations', function ($query) use ($class) {
                $query->where('specializations.id', $class->specialization_id);
            })
            ->get();
        $filter = $request->get('filter');
        $student = Auth::user();

        return view('credit.create', compact('filter', 'student', 'subjects'));
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
        //
    }
}
