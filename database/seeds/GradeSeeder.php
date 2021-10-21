<?php

use App\Models\Grade;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $grades = [
            'Khóa 1',
            'Khóa 2',
        ];
        foreach ($grades as $grade) {
            Grade::create([
                'name' => $grade,
            ]);
        }
    }
}
