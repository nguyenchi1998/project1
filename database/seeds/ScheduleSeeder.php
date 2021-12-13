<?php

use App\Models\Classs;
use App\Models\Schedule;
use App\Models\ScheduleDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        Classs::with([
            'students',
            'specialization',
            'specialization.subjects' => function ($query) {
                $query->whereType(config('subject.type.basic'));
            }, 'specialization.subjects.teachers'
        ])->get()->each(function ($class) use ($faker) {
            if ($class->semester <= config('config.class_register_limit_semester')) {
                $class->specialization->subjects->filter(function ($subject) use ($class) {
                    return $subject->pivot->semester <= $class->semester;
                })->each(function ($subject) use ($faker, $class) {
                    $teacherIds = $subject->teachers->pluck('id');
                    $startTime = Carbon::now()->subDays(random_int(30, 50));
                    $schedule = Schedule::create([
                        'name' => 'Lớp Tín Chỉ Môn ' . $subject->name,
                        'teacher_id' => $faker->randomElement($teacherIds),
                        'subject_id' => $subject->id,
                        'semester' => $class->semester,
                        'specialization_subject_id' => $subject->pivot->id,
                        'credit' => $subject->credit,
                        'start_time' => $startTime,
                        'end_time' => $startTime->copy()
                            ->addDays(config('config.range_time_schedule')),
                        'class_id' => $class->id,
                        'status' => $class->semster == config('config.class_register_limit_semester')
                            ? $faker->randomElement([
                                config('schedule.status.inprogress'),
                                config('schedule.status.finish'),
                                config('schedule.status.marking'),
                            ]) : config('schedule.status.done'),
                    ]);
                    $class->students->each(function ($student) use ($faker, $subject, $schedule, $class) {
                        $activityMark = $faker->randomElement(range(1, 9));
                        $middleMark = $faker->randomElement(range(1, 9));
                        $finalMark = $faker->randomElement(range(1, 9));
                        ScheduleDetail::create([
                            'student_id' => $student->id,
                            'subject_id' => $subject->id,
                            'specialization_id' => $student->class->specialization->id,
                            'schedule_id' => $schedule->id,
                            'semester' => $class->semester,
                            'register_status' => config('schedule.detail.status.register.success'),
                            'activity_mark' => $activityMark,
                            'middle_mark' => $middleMark,
                            'final_mark' => $finalMark,
                            'result_status' => result_schedule_detail(
                                $activityMark,
                                $middleMark,
                                $finalMark
                            )
                        ]);
                    });
                });
            } else {
                $specializationSubjects = $class->specialization->subjects->filter(
                    function ($subject) use ($class) {
                        return $subject->pivot->semester >= $class->semester;
                    }
                );
                $specializationSubjects->each(function ($subject) use ($class) {
                    $class->students->random(4)
                        ->each(function ($student) use ($subject) {
                            ScheduleDetail::create([
                                'student_id' => $student->id,
                                'subject_id' => $subject->id,
                                'specialization_id' => $subject->specialization->id,
                                'register_status' => config('schedule.detail.status.register.pending'),
                            ]);
                        });
                });
            }
        });
    }
}
