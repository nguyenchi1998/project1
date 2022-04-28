<?php

use App\Models\Department;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Teacher::class, 1)->create([
            'department_id' => 1,
            'name' => 'Teacher Chi',
            'email' => 'teacher@gmail.com',
        ]);
        $departmentIds = Department::all()->pluck('id')->toArray();
        factory(Teacher::class, 50)->create([
            'department_id' => $departmentIds[array_rand($departmentIds)]
        ]);
    }
}
