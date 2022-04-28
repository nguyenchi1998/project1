<?php

use App\Models\Grade;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 20) as $grade) {
            Grade::create([
                'name' => 'Khóa ' . $grade,
                'uuid' => Str::uuid(),
            ]);
        }
    }
}
