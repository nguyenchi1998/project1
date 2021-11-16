<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Repositories\IScheduleDetailRepository;
use App\Repositories\IScheduleRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    protected $scheduleRepository;
    protected $scheduleDetailsRepository;

    public function __construct(
        IScheduleRepository       $scheduleRepository,
        IScheduleDetailRepository $scheduleDetailsRepository
    ) {
        $this->scheduleRepository = $scheduleRepository;
        $this->scheduleDetailsRepository = $scheduleDetailsRepository;
    }

    public function index(Request $request)
    {
        $status = $request->get('status');
        $teacher = Auth::user();
        $states = array_map(function ($status) {
            return ucfirst($status);
        }, array_flip(config('schedule.status')));
        $statusSchedules = $this->scheduleRepository->where('teacher_id', '=', $teacher->id)
            ->whereIn('status', array_flip($states))
            ->when(isset($status), function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->get()
            ->load(['subject', 'class.students'])
            ->groupBy('status');

        return view('teacher.schedule', compact('statusSchedules', 'states', 'status'));
    }

    public function status(Request $request, $id)
    {
        $status = $request->get('status');
        if ($status == config('schedule.status.new')) {
            return $this->failRouteRedirect('Bạn không thể chỉnh trạng thái về trạng thái mới');
        } else {
            $this->scheduleRepository->update($id, [
                'status' => $status,
            ]);
            return $this->successRouteRedirect('teacher.schedules.index');
        }
    }

    public function attendanceShow($id)
    {
        $schedule = $this->scheduleRepository->find($id)
            ->load('scheduleDetails.student');
        $scheduleDetails = $schedule->scheduleDetails;

        return view('teacher.attendance', compact('scheduleDetails', 'schedule'));
    }

    public function attendance($id)
    {
        return $this->successRouteRedirect('teacher.schedules.attendanceShow', $id);
    }

    public function markShow(Request $request, $id)
    {
        $schedule = $this->scheduleRepository->find($id)
            ->load('scheduleDetails.student');
        $scheduleDetails = $schedule->scheduleDetails;

        return view('teacher.mark', compact('scheduleDetails', 'schedule'));
    }

    public function mark(Request $request, $id)
    {
        $schedule = $this->scheduleRepository->find($id)
            ->load('subject');
        foreach ($request->get('students') as $student) {
            $this->scheduleDetailsRepository->updateOrCreate(
                [
                    'schedule_id' => $id,
                    'student_id' => $student['student_id'],
                    'subject_id' => $schedule->specializationSubject->subject->id
                ],
                $student
            );
        }
    }
}
