<?php

use App\Models\Specialization;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class SpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $specializations = [
            'Kỹ thuật Cơ điện tử',
            'Kỹ thuật Cơ khí',
            'Kỹ thuật Ô tô',
            'Kỹ thuật Cơ khí động lực',
            'Kỹ thuật Hàng không',
            'Chương trình tiên tiến Cơ điện tử',
            'Chương trình tiên tiến Kỹ thuật Ô tô',
            'Kỹ thuật Điện'
        ];
        foreach ($specializations as $specialization) {
            $specialization =  Specialization::create([
                'name' => $specialization
            ]);
            $specialization->subjects()->attach(Subject::whereType(config('common.subjectType.basic'))->get('id'));
        }
    }
}
