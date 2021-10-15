<?php

use App\Models\Department;
use App\Models\Specialization;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = [
            [
                'name' => 'Viện Cơ khí',
                'specializations' => [
                    'Kỹ thuật Cơ điện tử',
                    'Kỹ thuật Cơ khí',
                    'Kỹ thuật Ô tô',
                    'Chương trình tiên tiến Cơ điện tử',
                    'Chương trình tiên tiến Kỹ thuật Ô tô'
                ],
            ], [
                'name' => 'Viện Cơ khí Động Lực',
                'specializations' => [
                    'Kỹ thuật Cơ khí động lực',
                    'Kỹ thuật Hàng không'
                ]
            ], [
                'name' => 'Viện Công Nghệ Sinh học và Công nghệ Thực phẩm',
                'specializations' => [
                    'Chương trình tiên tiến Kỹ thuật Hóa dược',
                    'Kỹ thuật Sinh học',
                    'Kỹ thuật Thực phẩm',
                    'Chương trình tiên tiến Kỹ thuật Thực phẩm',
                    'Kỹ thuật Môi trường'
                ]
            ], [
                'name' => 'Viện Công nghệ Thông tin và Truyền thông',
                'specializations' => [
                    'Kỹ thuật Điện tử - Viễn thông',
                    'Chương trình tiên tiến Điện tử - Viễn thông',
                    'Chương trình tiên tiến Kỹ thuật Y sinh',
                    'CNTT: Khoa học Máy tính'
                ]
            ], [
                'name' => 'Viện Điện',
                'specializations' => [
                    'Kỹ thuật Điện',
                    'Kỹ thuật Điều khiển - Tự động hóa',
                    'Chương trình tiên tiến Điều khiển-Tự động hóa và Hệ thống điện'
                ]
            ]
        ];

        foreach ($departments as $department) {
            $departmentInstance = Department::create([
                'name' => $department['name'],
            ]);
            foreach ($department['specializations'] as $specialization) {
                $specializationInstance = Specialization::create([
                    'name' => $specialization,
                    'department_id' => $departmentInstance->id,
                    'number_semester' => 6
                ]);
                $basicSubject = Subject::where('type', config('common.subjectType.basic'))->get()->pluck('id')->toArray();
                $specializationInstance->subjects()->sync($basicSubject);
            }
        }
    }
}
