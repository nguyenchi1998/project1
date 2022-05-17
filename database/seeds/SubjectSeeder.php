<?php

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subjects = [
            'Toán',
            'Vật Lý',
            "Hoá Học",
            'Sinh Học',
            'Tin Học',
            'Ngữ Văn',
            'Lịch Sử',
            'Địa Lý',
            'Ngoại Ngữ',
            'GDCD',
            'Công Nghệ',
            'Thể Dục',
            'GD QP AN'
        ];
        foreach ($subjects as $subject) {
            for ($i = 10; $i <= 12; $i++)
                Subject::create([
                    'name' => $subject . ' ' . $i,
                ]);
        }
    }
}
