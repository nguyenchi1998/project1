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
        $classes = ['IT', 'CK', 'TT', 'HH', 'PT'];
        $faker = Faker\Factory::create();
        $path = $faker->image(storage_path(config('default.path.app_public')), 200, 200);
        $studentRole = Role::findByName(config('config.roles.student.name'), config('config.roles.student.guard'));

        foreach ($classes as $class) {
            for ($i = 1; $i <= 3; $i++) {
                $classInstance = Classs::create([
                    'name' => $class . '-' . $i,
                    'specialization_id' => $faker->randomElement(Specialization::all()->random()->pluck('id')->toArray()),
                    'semester' => $faker->randomElement(range(1, 6)),
                ]);
                factory(Student::class, 5)->create([
                    'class_id' => $classInstance->id,
                    'grade_id' => $faker->randomElement(Grade::all()->pluck('id')->toArray()),
                ])->each(function ($student) use ($path, $studentRole) {
                    $media = Media::create([
                        'path' => str_replace(storage_path(config('default.path.app_public')), 'storage', $path),
                    ]);
                    $student->assignRole($studentRole);
                    $student->avatar()->save($media);
                });
            }
        }
        factory(Student::class)->create([
            'email' => 'student@gmail.com',
            'class_id' => $faker->randomElement(range(1, 10)),
            'grade_id' => $faker->randomElement(Grade::all()->pluck('id')->toArray()),
        ])->each(function ($student) use ($path, $studentRole) {
            $media = Media::create([
                'path' => str_replace(storage_path(config('default.path.app_public')), 'storage', $path),
            ]);
            $student->avatar()->save($media);
            $student->assignRole($studentRole);
        });
    }
}
