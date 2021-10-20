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
        $class = $this->classRepository->find($student->class_id)->load('specialization');
        $semester = range(1, $class->semester);
        $subjects = $this->scheduleDetailRepository->where('student_id', '=', $student->id)
            ->whereHas('schedule', function ($query) {
                $query->where('status', config('common.status.schedule.done'));
            })
            ->get()->load(['subject', 'schedule']);

        return view('mark.index', compact('subjects', 'semester', 'semesterFilter'));
    }
}
