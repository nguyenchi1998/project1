<?php

use App\Models\Classs;
use App\Models\Schedule;
use App\Models\ScheduleDetail;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
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
        Classs::with('students')->get()->each(function ($class, $key) use ($faker) {
            if ($class->semster <= config('config.class_register_limit_semester')) {
                Subject::whereType(config('subject.type.basic'))->get()->each(function ($subject) use ($faker, $class) {
                    $teacherIds = Teacher::whereHas('subjects', function ($query) use ($subject) {
                        $query->where('subjects.id', $subject->id);
                    })->get()->pluck('id');
                    $schedule = Schedule::create([
                        'teacher_id' => $faker->randomElement($teacherIds),
                        'subject_id' => $subject->id,
                        'name' => 'Lớp Tín Chỉ Môn ' . $subject->name,
                        'status' => $faker->randomElement(array_values(config('schedule.status'))),
                        'class_id' => $class->id,
                    ]);
                    $class->students->each(function ($student) use ($subject, $schedule) {
                        ScheduleDetail::create([
                            'student_id' => $student->id,
                            'subject_id' => $subject->id,
                            'schedule_id' => $schedule->id,
                            'register_status' => config('schedule_detail.status.register.success')
                        ]);
                    });
                });
            } else {
            }
        });
    }
}
