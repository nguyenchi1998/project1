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
        $student = Auth::user();
        $class = $this->classRepository->find($student->class_id)->load('specialization');
        $semesterFilter = $request->get('semester', $class->semester);
        $semester = range_semester(config('config.start_semester'), $class->semester);
        $subjects = $this->scheduleDetailRepository->where('student_id', '=', $student->id)
            ->whereHas('schedule', function ($query) {
                $query->where('status', config('schedule.status.done'));
            })
            ->get()->load(['subject', 'schedule']);

        return view('student.mark.index', compact('subjects', 'semester', 'semesterFilter'));
    }
}
