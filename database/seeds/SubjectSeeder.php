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
            ['name' => 'Những NLCB của CN Mác-Lênin I', 'type' => config('common.subjectType.basic')],
            ['name' => 'Những NLCB của CN Mác-Lênin II', 'type' => config('common.subjectType.basic')],
            ['name' => 'Tư tưởng Hồ Chí Minh', 'type' => config('common.subjectType.basic')],
            ['name' => 'Đường lối CM của Đảng CSVN', 'type' => config('common.subjectType.basic')],
            ['name' => 'Pháp luật đại cương ', 'type' => config('common.subjectType.basic')],
            ['name' => 'Lý luận thể dục thể thao', 'type' => config('common.subjectType.basic')],
            ['name' => 'Bơi lội', 'type' => config('common.subjectType.basic')],
            ['name' => 'Tự chọn thể dục 1', 'type' => config('common.subjectType.basic')],
            ['name' => 'Tự chọn thể dục 2', 'type' => config('common.subjectType.basic')],
            ['name' => 'Tự chọn thể dục 3', 'type' => config('common.subjectType.basic')],
            ['name' => 'Đường lối quân sự của Đảng', 'type' => config('common.subjectType.basic')],
            ['name' => 'Công tác quốc phòng, an ninh', 'type' => config('common.subjectType.basic')],
            ['name' => 'QS chung và chiến thuật, kỹ thuật bắn súng tiểu liên AK', 'type' => config('common.subjectType.basic')],
            ['name' => 'Tiếng Anh', 'type' => config('common.subjectType.basic')],
            ['name' => 'Kỹ thuật ghép nối máy tính',],
            ['name' => 'Hệ nhúng',],
            ['name' => 'Quản trị dự án công nghệ thông tin',],
            ['name' => 'Thiết kế IC',],
            ['name' => 'Kỹ thuật mô hình hóa và mô phỏng',],
        ];

        foreach ($subjects as $subject) {
            Subject::create([
                'name' => $subject['name'],
                'type' => $subject['type'] ?? null,
            ]);
        }
    }
}
