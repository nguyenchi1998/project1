<?php

use App\Models\ClassRoom;
use App\Models\Grade;
use App\Models\Media;
use App\Models\Specialization;
use App\Models\Student;
use Illuminate\Database\Seeder;

class ClassRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $path = $faker->image(
            realpath(storage_path(config('default.path.app_public'))),
            config('default.avatar_size'),
            config('default.avatar_size')
        );
        factory(Student::class)->create([
            'name' => 'Chi Student',
            'email' => 'student@gmail.com ',
            'class_room_id' => 1,
            'avatar' => str_replace(realpath(storage_path(config('default.path.app_public'))), '', $path),
        ]);
        foreach ([10, 11, 12] as $class) {
            for ($i = 1; $i <= 10; $i++) {
                $classInstance = ClassRoom::create([
                    'name' => $class . 'A' . $i,
                ]);
                factory(Student::class, $faker->randomElement([5, 10]))
                    ->create([
                        'class_room_id' => $classInstance->id,
                        'avatar' => str_replace(realpath(storage_path(config('default.path.app_public'))), '', $path),
                    ]);
            }
        }
    }
}
