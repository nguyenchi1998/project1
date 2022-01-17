<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Resources\ScheduleResource;
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
        $statusFilter = $request->get('status-filter', config('schedule.status.progress'));
        $teacher = Auth::user();
        $schedules = $this->scheduleRepository->model()
            ->where('teacher_id',  $teacher->id)
            ->where('status', $statusFilter)
            ->with(['subject', 'class.students', 'scheduleDetails'])
            ->get();

        return ScheduleResource::collection($schedules);
    }

    public function status(Request $request, $id)
    {
        $schedule = $this->scheduleRepository->find($id);
        $status = $request->get('status');
        if ($schedule->status != config('schedule.status.new') && $status == config('schedule.status.new')) {
            return $this->failRouteRedirect();
        } else {
            $this->scheduleRepository->update($id, [
                'status' => $status,
            ]);
            return $this->successRouteRedirect();
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
        return $this->successRouteRedirect();
    }

    public function mark(Request $request, $scheduleId)
    {
        $schedule = $this->scheduleRepository->find($scheduleId)
            ->load('subject');
        foreach ($request->get('students') as $student) {
            $this->scheduleDetailsRepository->updateOrCreate(
                [
                    'schedule_id' => $scheduleId,
                    'student_id' => $student['student_id'],
                    'subject_id' => $schedule->subject->id
                ],
                $student
            );
        }
    }
}
