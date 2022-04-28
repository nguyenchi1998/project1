<?php

use App\Models\Manager;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->resetData();

        $this->call(GradeSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(TeacherSeeder::class);
        $this->call(ManagerSeeder::class);
        $this->call(ClassRoomSeeder::class);
        $this->call(SubjectTeacherSeeder::class);
        $this->call(ScheduleSeeder::class);
    }

    private function resetData()
    {
        $tableNames = Schema::getConnection()->getDoctrineSchemaManager()->listTableNames();

        foreach ($tableNames as $name) {
            //if you don't want to truncate migrations
            if ($name == 'migrations') {
                continue;
            }
            DB::table($name)->truncate();
        }
    }
}
