<?php

use App\Models\Classs;
use App\Models\Grade;
use App\Models\Media;
use App\Models\Specialization;
use App\Models\Student;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class ClassSeeder extends Seeder
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
        $path = $faker->image(storage_path(config('default.path.app_public')), config('default.avatar_size'), config('default.avatar_size'));
        factory(Student::class)->create([
            'name' => 'Chi Student',
            'email' => 'student@gmail.com ',
            'class_id' => $faker->randomElement(range(1, count($classes))),
            'grade_id' => $faker->randomElement(Grade::all()->pluck('id')->toArray()),
        ])->each(function ($student) use ($path) {
            $media = Media::create([
                'path' => str_replace(storage_path(config('default.path.app_public')), '', $path),
            ]);
            $student->update([
                'code' => generate_code(Student::class, $student->id),
            ]);
            $student->avatar()->save($media);
        });
        foreach ($classes as $class) {
            for ($i = 1; $i <= 3; $i++) {
                $classInstance = Classs::create([
                    'name' => $class . ' - ' . $i,
                    'specialization_id' => $faker->randomElement(Specialization::all()->random()->pluck('id')->toArray()),
                    'semester' => $faker->randomElement(range(1, config('config.max_semester'))),
                ]);
                $classInstance->update([
                    'code' => generate_code(Classs::class, $classInstance->id),
                ]);
                factory(Student::class, $faker->randomElement([5, 10]))->create([
                    'class_id' => $classInstance->id,
                    'grade_id' => $faker->randomElement(Grade::all()->pluck('id')->toArray()),
                ])->each(function ($student) use ($path) {
                    $media = Media::create([
                        'path' => str_replace(storage_path(config('default.path.app_public')), '', $path),
                    ]);
                    $student->update([
                        'code' => generate_code(Student::class, $student->id),
                    ]);
                    $student->avatar()->save($media);
                });
            }
        }
    }
}
