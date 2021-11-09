<?php

namespace App\Http\Controllers;

use App\Repositories\IClassRepository;
use App\Repositories\IScheduleDetailRepository;
use App\Repositories\ISubjectRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarkController extends Controller
{
    protected $scheduleDetailRepository;
    protected $classRepository;
    protected $subjectRepository;

    public function __construct(
        IScheduleDetailRepository $scheduleDetailRepository,
        IClassRepository          $classRepository,
        ISubjectRepository        $subjectRepository
    ) {
        $this->scheduleDetailRepository = $scheduleDetailRepository;
        $this->classRepository = $classRepository;
        $this->subjectRepository = $subjectRepository;
    }

    public function index(Request $request)
    {
        $semesterFilter = $request->semester;
        $student = Auth::user();
        $class = $this->classRepository->find($student->class_id)->load('specialization');
        $semester = range(config('config.start_semester'), $class->semester);
        $subjects = $this->scheduleDetailRepository->where('student_id', '=', $student->id)
            ->whereHas('schedule', function ($query) {
                $query->where('status', config('config.status.schedule.done'));
            })
            ->get()->load(['subject', 'schedule']);

        return view('student.mark.index', compact('subjects', 'semester', 'semesterFilter'));
    }
}
