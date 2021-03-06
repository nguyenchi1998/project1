<?php

use App\Models\ClassRoom;
use App\Models\Schedule;
use App\Models\ScheduleDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

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
        ClassRoom::with([
            'students',
            'specialization',
            'specialization.subjects' => function ($query) {
                $query->whereType(config('subject.type.basic'));
            }, 'specialization.subjects.teachers'
        ])
            ->get()
            ->each(function ($class) use ($faker) {
                if ($class->semester <= config('config.class_register_limit_semester')) {
                    $class->specialization->subjects->filter(function ($subject) use ($class) {
                        return $subject->semester <= $class->semester;
                    })->each(function ($subject, $key) use ($faker, $class) {
                        $teacherIds = $subject->teachers->pluck('id');
                        $startTime = Carbon::now()->subDays(random_int(30, 50));
                        $schedule = Schedule::create([
                            'uuid' => Str::uuid(),
                            'teacher_id' => $faker->randomElement($teacherIds),
                            'subject_id' => $subject->id,
                            'semester' => $class->semester,
                            'credit' => $subject->credit,
                            'type' => config('schedule.type.main'),
                            'start_time' => $startTime,
                            'end_time' => $startTime->copy()
                                ->addDays(config('config.range_time_schedule')),
                            'class_room_id' => $class->id,
                            'status' => $class->semester == config('config.class_register_limit_semester')
                                ? $faker->randomElement([
                                    config('schedule.status.progress'),
                                    config('schedule.status.finish'),
                                    config('schedule.status.marking'),
                                ]) : config('schedule.status.done'),
                        ]);
                        $class->students->each(function ($student) use ($faker, $subject, $schedule, $class) {
                            $activityMark = $faker->randomElement(range(1, 9));
                            $middleMark = $faker->randomElement(range(1, 9));
                            $finalMark = $faker->randomElement(range(1, 9));

                            ScheduleDetail::create([
                                'uuid' => Str::uuid(),
                                'student_id' => $student->id,
                                'subject_id' => $subject->id,
                                'specialization_id' => $class->specialization_id,
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
                            return $subject->semester > $class->semester;
                        }
                    );
                    $specializationSubjects->each(function ($subject) use ($class) {
                        $class->students->random(4)
                            ->each(function ($student) use ($subject, $class) {
                                ScheduleDetail::create([
                                    'uuid' => Str::uuid(),
                                    'student_id' => $student->id,
                                    'subject_id' => $subject->id,
                                    'specialization_id' => $class->specialization_id,
                                    'register_status' => config('schedule.detail.status.register.pending'),
                                ]);
                            });
                    });
                }
            });
    }
}
