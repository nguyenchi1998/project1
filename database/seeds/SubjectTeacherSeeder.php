<?php

use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class SubjectTeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        Teacher::all()->each(function ($teacher) use ($faker) {
            $subjects = Subject::where('department_id', $teacher->department_id)->get()->pluck('id');
            $teacher->subjects()->sync($faker->randomElements($subjects, random_int(1, count($subjects))));
        });
    }
}
