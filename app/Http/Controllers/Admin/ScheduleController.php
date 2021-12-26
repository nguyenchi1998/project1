<?php

namespace App\Http\Controllers\Admin;

use App\Exports\MarkExport;
use App\Http\Controllers\Controller;
use App\Repositories\IClassRepository;
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
        IScheduleRepository $scheduleRepository,
        IScheduleDetailRepository $scheduleDetailRepository,
        ISpecializationRepository $specializationRepository,
        ISubjectRepository $subjectRepository,
        IClassRepository $classRepository,
        IStudentRepository $studentRepository
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
        $hasScheduleDetails = count($this->calculateScheduleDetails());
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
                $query->where('code', $keyword)
                    ->orWhereHas('subject', function ($query) use ($keyword) {
                        $query->where('name', 'like', '%' . $keyword . '%');
                    });;
            })
            ->when(isset($classType), function ($query) use ($classType) {
                $query->when($classType, function ($query) {
                    $query->whereNull('class_id');
                }, function ($query) {
                    $query->whereNotNull('class_id');
                });
            })
            ->with(['subject.teachers', 'teacher', 'scheduleDetails'])
            ->orderBy('status', 'asc')
            ->paginate(config('config.paginate'));

        return view('admin.schedule.index', compact(
            'schedules',
            'status',
            'hasScheduleDetails',
            'classType',
            'keyword'
        ));
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

    public function create()
    {
        $scheduleDetails = $this->calculateScheduleDetails();

        return view('admin.schedule.create', compact('scheduleDetails'));
    }

    public function store(Request $request)
    {
        try {
            $subject = $this->subjectRepository->find($request->get('subject_id'));
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

            return $this->successRouteRedirect('admin.schedules.index');
        } catch (Exception $e) {
            DB::rollBack();

            return $this->failRouteRedirect($e->getMessage());
        }
    }

    public function show($id)
    {
        $schedule = $this->scheduleRepository->find($id)
            ->load('scheduleDetails');

        return view('admin.schedule.show', compact(
            'schedule'
        ));
    }

    public function export($id)
    {
        $schedule = $this->scheduleRepository->find($id)
            ->load('scheduleDetails.student');
        $filename = $schedule->code . '-mark.xlsx';
        $data = $schedule->scheduleDetails->map(function ($scheduleDetail) {
            $item['code'] = $scheduleDetail->student->code;
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

    public function edit($id)
    {
        $schedule = $this->scheduleRepository->find($id);
        $teachers = $schedule->subject->teachers->pluck('name', 'id')
            ->toArray();

        return view('admin.schedule.edit', compact(
            'schedule',
            'teachers'
        ));
    }

    public function update(Request $request, $scheduleId)
    {
        $schedule = $this->scheduleRepository->find($scheduleId);
        $schedule->update(
            array_merge(
                $request->only(['teacher_id', 'start_time', 'end_time']),
                [
                    'status' => $request->status ?? ($schedule->teacher
                        && $schedule->start_time
                        ? config('schedule.status.inprogress') : $schedule->status),
                ]
            )
        );

        return $this->successRouteRedirect('admin.schedules.index');
    }

    public function destroy($id)
    {
        $this->scheduleRepository->delete($id);

        return $this->successRouteRedirect('admin.schedules.index');
    }

    public function restore($id)
    {
        $result = $this->scheduleRepository->restore($id);
        if ($result) {
            return $this->successRouteRedirect('admin.schedules.index');
        }

        return $this->failRouteRedirect();
    }

    public function scheduleTimeShow($id)
    {
        $schedule = $this->scheduleRepository->find($id);

        return view('admin.schedule.schedule_time', compact('schedule'));
    }

    public function scheduleTime(Request $request, $id)
    {
        $this->scheduleRepository->update($id, [
            'schedule_time' => json_encode($request->get('timeschedules'))
        ]);
    }
}
