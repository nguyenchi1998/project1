<?php

use App\Models\Classs;
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
        foreach ($classes as $class) {
            for ($i = 1; $i <= 5; $i++) {
                $classInstance =  Classs::create([
                    'name' => $class . '-' . $i,
                ]);
                factory(Student::class, 15)->create([
                    'class_id' => $classInstance->id
                ]);
            }
        }

        factory(Student::class, 20)->create();
    }
}
