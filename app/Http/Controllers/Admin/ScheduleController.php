<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\IClassRepository;
use App\Repositories\IScheduleRepository;
use App\Repositories\ISpecializationRepository;
use App\Repositories\ISubjectRepository;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    protected $scheduleRepository;
    protected $specializationRepository;
    protected $subjectRepository;
    protected $classRepository;

    public function __construct(
        IScheduleRepository       $scheduleRepository,
        ISpecializationRepository $specializationRepository,
        ISubjectRepository        $subjectRepository,
        IClassRepository          $classRepository
    )
    {
        $this->scheduleRepository = $scheduleRepository;
        $this->specializationRepository = $specializationRepository;
        $this->subjectRepository = $subjectRepository;
        $this->classRepository = $classRepository;
    }

    public function index(Request $request)
    {
        $semesters = ['1' => 'Semester 1', '2' => 'Semester 2'];
        $semester = $request->get('semester');
        $classId = $request->get('class');
        $schedules = $this->scheduleRepository->all()->load('subject', 'teacher', 'scheduleDetails');
        $allClasses = $this->classRepository->where('semester', '<=', 2)
            ->when($semester, function ($query) use ($semester) {
                $query->where('semester', $semester);
            })
            ->get()
            ->load('specialization.subjects');
        $basicSubjects = $this->subjectRepository->model()
            ->basicSubjects()->get();
        $scheduleClass = $this
            ->scheduleRepository->where('class_id', '!=', null)
            ->get()
            ->load('subject');
        $allClasses = $allClasses->map(function ($class) use ($scheduleClass, $basicSubjects) {
            $subjects = $scheduleClass->where('class_id', $class->id)->all();
            $specializationSubjects = $basicSubjects->diff($subjects);
            $class['unCreditSubjects'] = $specializationSubjects;
            return $class;
        });

        return view('admin.schedule.class.index', compact('allClasses', 'basicSubjects', 'semester', 'semesters'));
    }

    public function registerScheduleShow(Request $request, $id)
    {
        $class = $this->classRepository->find($id)->load('specialization');
        $basicSubjects = $this->subjectRepository->model()->basicSubjects()->get()->load('teachers');
        $schedules = $this->scheduleRepository->where('class_id', '=', $id)->get()->load('subject');
        $scheduleSubjects = $schedules->map(function ($schedule) {
            return $schedule->subject;
        });
        $unCreditSubjects = $basicSubjects->diff($scheduleSubjects);

        return view('admin.schedule.class.create', compact('unCreditSubjects', 'id', 'class'));
    }

    public function registerSchedule(Request $request, $id)
    {
        try {
            $subject = $this->subjectRepository->find($request->get('subject_id'));
            $this->scheduleRepository->create([
                'name' => '[Class] ' . $subject->name,
                'class_id' => $id,
                'subject_id' => $request->get('subject_id'),
                'start_time' => $request->get('start_time'),
            ]);
            $schedule = $this->scheduleRepository->model()->where(['class_id' => $id, 'subject_id' => $request->get('subject_id'),])->first();
            $class = $this->classRepository->find($id)->load('students');
            $students = $class->students->map(function ($student) use ($schedule, $request) {
                return [
                    'schedule_id' => $schedule->id,
                    'student_id' => $student->id,
                    'subject_id' => $request->get('subject_id'),
                ];
            });
            $schedule->scheduleDetails()->createMany($students);

            return redirect()->route('admin.schedules.registerShow', $id)->with('success', 'Register credit success for class ' . $class->name);
        } catch (Exception $e) {
            DB::rollBack();

            return back()->withErrors(['msg' => $e->getMessage()]);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
