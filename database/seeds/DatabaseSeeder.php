<?php

use App\Models\Manager;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(GradeSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(TeacherSeeder::class);
        $this->call(ManagerSeeder::class);
        $this->call(ClassSeeder::class);
        $this->call(SubjectTeacherSeeder::class);
        // $this->call(ScheduleSeeder::class);
    }
}
