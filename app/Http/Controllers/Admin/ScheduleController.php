<?php

namespace App\Http\Controllers\Admin;

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
        IScheduleRepository       $scheduleRepository,
        IScheduleDetailRepository $scheduleDetailRepository,
        ISpecializationRepository $specializationRepository,
        ISubjectRepository        $subjectRepository,
        IClassRepository          $classRepository,
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
        $hasScheduleDetails = count($this->calculateScheduleDetails());
        $classType = $request->get('class-type');
        $status = $request->get('status');
        $states = array_map(function ($item) {
            return ucfirst($item);
        }, array_flip(config('schedule.status')));
        $schedules = $this->scheduleRepository->model()
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when(isset($classType), function ($query) use ($classType) {
                $query->where('class_id', $classType ? '=' : '!=', null);
            })
            ->with(['specializationSubject.subject.teachers', 'teacher', 'scheduleDetails'])
            ->orderBy('status', 'asc')
            ->paginate(config('config.paginate'));

        return view('admin.schedule.index', compact('states', 'schedules', 'status', 'hasScheduleDetails', 'classType'));
    }

    protected function calculateScheduleDetails()
    {
        $scheduleDetails = $this->scheduleDetailRepository->model()
            ->doesntHave('schedule')
            ->get()
            ->load('specializationSubject.subject.teachers')
            ->reduce(function (&$subjects, $scheduleDetail) {
                if (isset($subjects[$scheduleDetail->specialization_subject_id])) {
                    $subjects[$scheduleDetail->specialization_subject_id] = [
                        'subject' => $scheduleDetail->specializationSubject->subject->toArray(),
                        'schedule_details' => array_merge($subjects[$scheduleDetail->specialization_subject_id]['schedule_details'], [$scheduleDetail->id])
                    ];
                } else {
                    $subjects[$scheduleDetail->specialization_subject_id] = [
                        'subject' => $scheduleDetail->specializationSubject->subject->toArray(),
                        'schedule_details' => [$scheduleDetail->id],
                    ];
                }
                return $subjects;
            }, []);
        return array_map(function ($item) {
            $item['subject']['teachers'] = collect($item['subject']['teachers'])->pluck('name', 'id');

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
            $schedule = $this->scheduleRepository->create(array_merge(
                $request->only(['subject_id', 'start_time', 'end_time', 'teacher_id']),
                ['name' => 'Lớp tín chỉ môn ' . $subject->name,]
            ));
            $this->scheduleDetailRepository->model()
                ->whereIn('id', $request->get('schedule_details'))
                ->update([
                    'schedule_id' => $schedule->id,
                    'register_pending' => config('schedule_detail.status.register.success')
                ]);

            return $this->successRouteRedirect('admin.schedules.index');
        } catch (Exception $e) {
            DB::rollBack();

            return $this->failRouteRedirect($e->getMessage());
        }
    }

    public function destroy($id)
    {
        $schedule = $this->scheduleRepository->delete($id);

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
            'schedule_time' => json_encode($request->timeschedules)
        ]);
    }

    public function setTeacher(Request $request, $id)
    {
        $this->scheduleRepository->update($id, $request->only('teacher_id'));

        return $this->successRouteRedirect('admin.schedules.index');
    }

    public function startSchedule(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $schedule = $this->scheduleRepository->find($id)->load('class.students');
            if ($schedule->status == config('schedule.status.new')) {
                $students = $schedule->class->students->map(function ($student) use ($schedule) {
                    $item['student_id'] = $student->id;
                    $item['specialization_subject_id'] = $schedule->specialization_subject_id;
                    $item['schedule_id'] = $schedule->id;
                    return $item;
                })->toArray();
                $schedule->update($request->only('status'));
                $schedule->scheduleDetails()->createMany($students);
            }
            DB::commit();

            return $this->successRouteRedirect('admin.schedules.index');
        } catch (Exception $e) {
            DB::rollBack();

            return $this->failRouteRedirect($e->getMessage());
        }
    }
}
