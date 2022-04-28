<?php

use App\Models\ClassRoom;
use App\Models\Grade;
use App\Models\Media;
use App\Models\Specialization;
use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ClassRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classes = ['Công nghệ thông tin ', 'Cơ Khí ', 'Toán Tin ', 'Tàu Thủy ', 'Cơ Điện Tử '];
        $faker = Faker\Factory::create();
        factory(Student::class)->create([
            'name' => 'Chi Student',
            'email' => 'student@gmail.com ',
            'class_room_id' => $faker->randomElement(range(1, count($classes))),
            'grade_id' => $faker->randomElement(Grade::all()->pluck('id')->toArray()),
        ]);
        foreach ($classes as $class) {
            for ($i = 1; $i <= 3; $i++) {
                $classInstance = ClassRoom::create([
                    'name' => $class . ' - ' . $i,
                    'specialization_id' => $faker->randomElement(Specialization::all()->random()->pluck('id')->toArray()),
                    'semester' => $faker->randomElement(range(1, config('config.max_semester'))),
                    'uuid' => Str::uuid(),
                ]);

                factory(Student::class, $faker->randomElement([5, 10]))->create([
                    'class_room_id' => $classInstance->id,
                    'grade_id' => $faker->randomElement(Grade::all()->pluck('id')->toArray()),
                ]);
            }
        }
    }
}
