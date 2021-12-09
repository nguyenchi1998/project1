<?php

use App\Models\Classs;
use App\Models\Schedule;
use App\Models\ScheduleDetail;
use Illuminate\Database\Seeder;

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
        Classs::with(['students', 'specialization', 'specialization.subjects' => function ($query) {
            $query->whereType(config('subject.type.basic'));
        }, 'specialization.subjects.teachers'])
            ->get()
            ->each(function ($class) use ($faker) {
                if ($class->semster <= config('config.class_register_limit_semester')) {
                    $class->specialization->subjects->each(function ($subject) use ($faker, $class) {
                        $teacherIds = $subject->teachers->pluck('id');
                        $schedule = Schedule::create([
                            'teacher_id' => $faker->randomElement($teacherIds),
                            'specialization_subject_id' => $subject->pivot->id,
                            'name' => 'Lớp Tín Chỉ Môn ' . $subject->name,
                            'status' => $faker->randomElement(array_values(config('schedule.status'))),
                            'class_id' => $class->id,
                        ]);
                        $class->students->each(function ($student) use ($faker, $subject, $schedule) {
                            $activityMark = $faker->randomElement(range(1, 9));
                            $middleMark = $faker->randomElement(range(1, 9));
                            $finalMark = $faker->randomElement(range(1, 9));
                            ScheduleDetail::create([
                                'student_id' => $student->id,
                                'specialization_subject_id' => $subject->pivot->id,
                                'schedule_id' => $schedule->id,
                                'register_status' => config('schedule.detail.status.register.success'),
                                'activity_mark' => $activityMark,
                                'middle_mark' => $middleMark,
                                'final_mark' => $finalMark,
                                'result_status' => result_schedule_detail($activityMark, $middleMark, $finalMark)
                            ]);
                        });
                    });
                }
            });
    }
}
