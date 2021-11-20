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
        Subject::all()->each(
            function ($subject) use ($faker) {
                $teacherIds = Teacher::where('department_id', $subject->department_id)->get()->pluck('id');
                $subject->teachers()->sync($faker->randomElements($teacherIds, $faker->randomElement(range(4, count($teacherIds)))));
            }
        );
    }
}
