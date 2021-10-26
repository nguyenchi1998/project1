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

class ScheduleClassController extends Controller
{
    const MAX_SEMESTER_REGISTER_BY_CLASS = 4;

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
    )
    {
        $this->scheduleRepository = $scheduleRepository;
        $this->specializationRepository = $specializationRepository;
        $this->subjectRepository = $subjectRepository;
        $this->classRepository = $classRepository;
        $this->studentRepository = $studentRepository;
        $this->scheduleDetailRepository = $scheduleDetailRepository;
    }

    public function index(Request $request)
    {
        $status = $request->get('status');
        $states = array_map(function ($item) {
            return ucfirst($item);
        }, array_flip(config('config.status.schedule')));
        $schedules = $this->scheduleRepository->model()
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->get()
            ->load('subject', 'teacher', 'scheduleDetails');

        return view('admin.schedule.class.index', compact('states', 'schedules', 'status'));
    }

    public function create()
    {
        $scheduleDetails = $this->scheduleDetailRepository->model()
            ->doesntHave('schedule')
            ->get()
            ->load('subject.teachers')
            ->reduce(function (&$subjects, $scheduleDetail) {
                if (isset($subjects[$scheduleDetail->subject_id])) {
                    $subjects[$scheduleDetail->subject_id] = [
                        'subject' => $scheduleDetail->subject->toArray(),
                        'schedule_details' => array_merge($subjects[$scheduleDetail->subject_id]['schedule_details'], [$scheduleDetail->id])
                    ];
                } else {
                    $subjects[$scheduleDetail->subject_id] = [
                        'subject' => $scheduleDetail->subject->toArray(),
                        'schedule_details' => [$scheduleDetail->id],
                    ];
                }
                return $subjects;
            }, []);
        $scheduleDetails = array_map(function ($item) {
            $item['subject']['teachers'] = collect($item['subject']['teachers'])->pluck('name', 'id');

            return $item;
        }, $scheduleDetails);

        return view('admin.schedule.class.create', compact('scheduleDetails'));
    }

    public function store(Request $request)
    {
        try {
            $subject = $this->subjectRepository->find($request->get('subject_id'));
            $schedule = $this->scheduleRepository->create([
                'name' => 'Lớp tín chỉ môn ' . $subject->name,
                'subject_id' => $request->get('subject_id'),
                'start_time' => $request->get('start_time'),
            ]);
            $this->scheduleDetailRepository->model()
                ->whereIn('id', $request->get('schedule_details'))
                ->update([
                    'schedule_id' => $schedule->id,
                ]);

            return redirect()->route('admin.schedules.index')
                ->with('success', 'Tạo Lớp Tín Chỉ Môn "' . $subject->name . '" Thành Công');
        } catch (Exception $e) {
            DB::rollBack();

            return back()->withErrors(['msg' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $schedule = $this->scheduleRepository->find($id);
        $this->scheduleRepository->delete($id, $schedule->status == config('config.status.schedule.new'));

        return redirect()->route('admin.schedules.index');
    }
}
