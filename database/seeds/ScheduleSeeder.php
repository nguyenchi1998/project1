<?php

use App\Models\ClassRoom;
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
        ClassRoom::all()->each(function ($class) {
            $schedule = Schedule::create([
                'name' => 'Schedule Class ' . $class->name,
                'class_room_id' => $class->id,
                'active' => 1,
            ]);

            foreach (range(0, 6) as $weekDay) {
                foreach (range(0, 4) as $lesson) {
                    ScheduleDetail::create([
                        'schedule_id' => $schedule->id,
                        'week_day' => $weekDay,
                    ]);
                }
            }
        });
    }
}
