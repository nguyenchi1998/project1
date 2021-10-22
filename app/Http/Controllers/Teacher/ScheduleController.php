<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Repositories\IScheduleDetailRepository;
use App\Repositories\IScheduleRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    protected $scheduleRepository;
    protected $scheduleDetailsRepository;

    public function __construct(IScheduleRepository $scheduleRepository, IScheduleDetailRepository $scheduleDetailsRepository)
    {
        $this->scheduleRepository = $scheduleRepository;
        $this->scheduleDetailsRepository = $scheduleDetailsRepository;
    }

    public function index(Request $request)
    {
        $status = $request->get('status');
        $teacher = Auth::user();
        $states = array_map(function ($status) {
            return ucfirst($status);
        }, array_flip(config('common.status.schedule')));
        $schedules = $this->scheduleRepository->where('teacher_id', '=', $teacher->id)
            ->whereIn('status', array_flip($states))
            ->when(isset($status), function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->get()
            ->load('subject')
            ->groupBy('status');

        return view('teacher.schedule', compact('schedules', 'states', 'status'));
    }

    public function attendanceShow($id)
    {
        $schedule = $this->scheduleRepository->find($id)->load('scheduleDetails.student');
        $scheduleDetails = $schedule->scheduleDetails;

        return view('teacher.attendance', compact('scheduleDetails', 'schedule'));
    }

    public function attendance($id)
    {
        $schedule = $this->scheduleRepository->find($id)->load('scheduleDetails.student');
        $scheduleDetails = $schedule->scheduleDetails;

        return view('teacher.attendance', compact('scheduleDetails', 'schedule'));
    }

    public function markShow(Request $request, $id)
    {
        $schedule = $this->scheduleRepository->find($id)
            ->load('scheduleDetails.student');
        $scheduleDetails = $schedule->scheduleDetails;
        $statusScheduleDetails = array_flip(config('common.status.scheduleDetail'));
        $statusScheduleDetails = array_map(function ($status) {
            return ucfirst($status);
        }, $statusScheduleDetails);

        return view('teacher.mark', compact('scheduleDetails', 'schedule', 'statusScheduleDetails'));
    }

    public function mark(Request $request, $id)
    {
        $schedule = $this->scheduleRepository->find($id)->load('subject');
        foreach ($request->get('students') as $student) {
            $this->scheduleDetailsRepository->updateOrCreate(
                [
                    'schedule_id' => $id,
                    'student_id' => $student['student_id'],
                    'subject_id' => $schedule->subject->id
                ],
                $student,
            );
        }
    }
}
