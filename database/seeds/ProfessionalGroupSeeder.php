<?php

use App\Models\ProfessionalGroup;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class ProfessionalGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subjects = Subject::all();

        foreach ($subjects as $subject) {
            ProfessionalGroup::create([
                'name' => 'Tổ Bộ Môn ' . $subject->name,
            ]);
        }
    }
}
