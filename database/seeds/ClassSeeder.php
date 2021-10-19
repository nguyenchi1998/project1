<?php

use App\Models\Classs;
use App\Models\Media;
use App\Models\Specialization;
use App\Models\Student;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classes = ['IT', 'CK', 'TT'];
        $faker = Faker\Factory::create();
        if (
            !file_exists(
                (
                    'storage/app/public' . config('default.path.media.avatar.student')
                )
            )
        ) {
            mkdir('storage/app/public' . config('default.path.media.avatar.student'), 777, true);
        }
        $path = $faker->image('storage/app/public' . config('default.path.media.avatar.student'), 200, 200);
        foreach ($classes as $class) {
            for ($i = 1; $i <= 3; $i++) {
                $classInstance = Classs::create([
                    'name' => $class . '-' . $i,
                    'specialization_id' => $faker->randomElement(Specialization::all()->random()->pluck('id')->toArray()),
                    'semester' => 1
                ]);
                factory(Student::class, 5)->create([
                    'class_id' => $classInstance->id,
                    'grade_id' => 1
                ])->each(function ($student) use ($path) {

                    $media = Media::create([
                        'path' => 'storage/' . str_replace('storage/app/public/', '', $path),
                    ]);
                    $student->avatar()->save($media);
                });
            }
        }
        factory(Student::class)->create([
            'email' => 'student@gmail.com',
            'class_id' => 1,
            'grade_id' => 1,
        ])->each(function ($student) use ($path) {
            $media = Media::create([
                'path' => 'storage/' . str_replace('storage/app/public/', '', $path),
            ]);
            $student->avatar()->save($media);
        });

    }
}
