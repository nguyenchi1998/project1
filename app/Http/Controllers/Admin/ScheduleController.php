<?php

namespace App\Http\Controllers\Admin;

use App\Exports\MarkExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\ScheduleCollection;
use App\Http\Resources\ScheduleResource;
use App\Repositories\IClassRoomRepository;
use App\Repositories\IScheduleDetailRepository;
use App\Repositories\IScheduleRepository;
use App\Repositories\ISpecializationRepository;
use App\Repositories\IStudentRepository;
use App\Repositories\ISubjectRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    protected $scheduleRepository;
    protected $specializationRepository;
    protected $subjectRepository;
    protected $classRepository;
    protected $studentRepository;
    protected $scheduleDetailRepository;

    public function __construct(
        IScheduleRepository       $scheduleRepository,
        IScheduleDetailRepository $scheduleDetailRepository,
        ISpecializationRepository $specializationRepository,
        ISubjectRepository        $subjectRepository,
        IClassRoomRepository          $classRepository,
        IStudentRepository        $studentRepository
    ) {
        $this->scheduleRepository = $scheduleRepository;
        $this->specializationRepository = $specializationRepository;
        $this->subjectRepository = $subjectRepository;
        $this->classRepository = $classRepository;
        $this->studentRepository = $studentRepository;
        $this->scheduleDetailRepository = $scheduleDetailRepository;
    }

    public function index(Request $request)
    {
        $classType = $request->get('class-type');
        $status = $request->get('status', config('schedule.status.new'));
        $keyword = $request->get('keyword');
        $schedules = $this->scheduleRepository->model()
            ->where('status', $status)
            ->where(function ($query) {
                $query->whereHas('class', function ($query) {
                    $query->inprogressClass();
                })->orWhere(function ($query) {
                    $query->doesntHave('class');
                });
            })
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('subject', function ($query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%');
                });
            })
            ->when(isset($classType), function ($query) use ($classType) {
                $query->when($classType, function ($query) {
                    $query->whereNull('class_room_id');
                }, function ($query) {
                    $query->whereNotNull('class_room_id');
                });
            })
            ->with(['subject.teachers', 'teacher', 'scheduleDetails'])
            ->orderBy('status', 'asc')
            ->get();

        return ScheduleResource::collection($schedules);
    }

    public function show($id)
    {
        $schedule = $this->scheduleRepository->findOrFail($id);

        return new ScheduleResource($schedule);
    }

    public function store(Request $request)
    {
        try {
            $subject = $this->subjectRepository->findOrFail($request->get('subject_id'));
            $schedule = $this->scheduleRepository->create(
                array_merge($request->only([
                    'subject_id',
                    'start_time',
                    'end_time',
                    'teacher_id'
                ]), [
                    'credit' => $subject->credit,
                ])
            );
            $this->scheduleDetailRepository->model()
                ->whereIn('id', $request->get('schedule_details'))
                ->update([
                    'schedule_id' => $schedule->id,
                    'register_status' => config('schedule.detail.status.register.success')
                ]);

            return $this->successResponse();
        } catch (Exception $e) {
            DB::rollBack();

            return $this->errorResponse($e->getMessage());
        }
    }

    public function export($id)
    {
        $schedule = $this->scheduleRepository->find($id)
            ->load('scheduleDetails.student');
        $filename = $schedule->code . '-mark.xlsx';
        $data = $schedule->scheduleDetails->map(function ($scheduleDetail) {
            $item['name'] = $scheduleDetail->student->name;
            $item['mark'] = result_mark(
                $scheduleDetail->activity_mark,
                $scheduleDetail->middle_mark,
                $scheduleDetail->final_mark
            );

            return $item;
        });

        return (new MarkExport($data))->download($filename);
    }

    public function update(Request $request, $scheduleId)
    {
        $schedule = $this->scheduleRepository->find($scheduleId);
        $schedule->update(
            array_merge(
                $request->only(['teacher_id', 'start_time', 'end_time']),
                [
                    'status' => $request->status ?? ($schedule->teacher && $schedule->start_time
                        ? config('schedule.status.progress')
                        : $schedule->status
                    ),
                ]
            )
        );

        return $this->successResponse();
    }

    public function destroy($id)
    {
        $this->scheduleRepository->delete($id);

        return $this->successResponse();
    }

    public function restore($id)
    {
        $result = $this->scheduleRepository->restore($id);
        if ($result) {
            return $this->successResponse();
        }

        return $this->errorResponse();
    }

    public function scheduleTimeShow($id)
    {
        $schedule = $this->scheduleRepository->find($id);

        return view('admin.schedule.schedule_time', compact('schedule'));
    }

    public function scheduleTime(Request $request, $id)
    {
        $result = $this->scheduleRepository->update($id, [
            'schedule_time' => json_encode($request->get('timeschedules'))
        ]);
        if ($result) {
            return $this->successResponse();
        }

        return $this->errorResponse();
    }

    protected function calculateScheduleDetails()
    {
        $scheduleDetails = $this->scheduleDetailRepository->model()
            ->doesntHave('schedule')
            ->get()
            ->load('subject.teachers')
            ->reduce(function (&$subjects, $scheduleDetail) {
                if (isset($subjects[$scheduleDetail->subject_id])) {
                    $subjects[$scheduleDetail->subject_id] = [
                        'subject' => $scheduleDetail->subject->toArray(),
                        'schedule_details' => array_merge(
                            $subjects[$scheduleDetail->subject_id]['schedule_details'],
                            [$scheduleDetail->id]
                        )
                    ];
                } else {
                    $subjects[$scheduleDetail->subject_id] = [
                        'subject' => $scheduleDetail->subject->toArray(),
                        'schedule_details' => [$scheduleDetail->id],
                    ];
                }
                return $subjects;
            }, []);
        return array_map(function ($item) {
            $item['subject']['teachers'] = collect($item['subject']['teachers'])
                ->pluck('name', 'id');

            return $item;
        }, $scheduleDetails);
    }
}
