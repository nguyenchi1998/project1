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
            ['name' => 'Những NLCB của CN Mác-Lênin I', 'type' => config('common.subject.type.basic')],
            ['name' => 'Những NLCB của CN Mác-Lênin II', 'type' => config('common.subject.type.basic')],
            ['name' => 'Tư tưởng Hồ Chí Minh', 'type' => config('common.subject.type.basic')],
            ['name' => 'Đường lối CM của Đảng CSVN', 'type' => config('common.subject.type.basic')],
            ['name' => 'Pháp luật đại cương ', 'type' => config('common.subject.type.basic')],
            ['name' => 'Lý luận thể dục thể thao', 'type' => config('common.subject.type.basic')],
            ['name' => 'Bơi lội', 'type' => config('common.subject.type.basic')],
            ['name' => 'Tự chọn thể dục 1', 'type' => config('common.subject.type.basic')],
            ['name' => 'Tự chọn thể dục 2', 'type' => config('common.subject.type.basic')],
            ['name' => 'Tự chọn thể dục 3', 'type' => config('common.subject.type.basic')],
            ['name' => 'Đường lối quân sự của Đảng', 'type' => config('common.subject.type.basic')],
            ['name' => 'Công tác quốc phòng, an ninh', 'type' => config('common.subject.type.basic')],
            ['name' => 'QS chung và chiến thuật, kỹ thuật bắn súng tiểu liên AK', 'type' => config('common.subject.type.basic')],
            ['name' => 'Tiếng Anh', 'type' => config('common.subject.type.basic')],
            ['name' => 'Kỹ thuật ghép nối máy tính', 'type' => config('common.subject.type.specialization')],
            ['name' => 'Hệ nhúng', 'type' => config('common.subject.type.specialization')],
            ['name' => 'Quản trị dự án công nghệ thông tin', 'type' => config('common.subject.type.specialization')],
            ['name' => 'Thiết kế IC', 'type' => config('common.subject.type.specialization')],
            ['name' => 'Kỹ thuật mô hình hóa và mô phỏng', 'type' => config('common.subject.type.specialization')],
        ];

        foreach ($subjects as $subject) {
            Subject::create([
                'name' => $subject['name'],
                'type' => $subject['type'],
                'semester' => 1,
                'force' => isset($subject['type']) && $subject['type'] == config('common.subject.type.basic'),
                'department_id' => 1,
            ]);
        }
    }
}
