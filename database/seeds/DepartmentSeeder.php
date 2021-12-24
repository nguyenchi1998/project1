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
                    'Chương trình tiên tiến Điều khiển - Tự động hóa và Hệ thống điện',
                    'Kĩ thuật robot',
                ]
            ]
        ];
        $subjects = [
            [
                'name' => 'Những NLCB của CN Mác-Lênin I',
                'type' => config('subject.type.basic')
            ], [
                'name' => 'Những NLCB của CN Mác-Lênin II',
                'type' => config('subject.type.basic')
            ], [
                'name' => 'Tư tưởng Hồ Chí Minh',
                'type' => config('subject.type.basic')
            ], [
                'name' => 'Đường lối CM của Đảng CSVN',
                'type' => config('subject.type.basic')
            ], [
                'name' => 'Pháp luật đại cương ',
                'type' => config('subject.type.basic')
            ], [
                'name' => 'Lý luận thể dục thể thao',
                'type' => config('subject.type.basic')
            ], [
                'name' => 'Bơi lội',
                'type' => config('subject.type.basic')
            ], [
                'name' => 'Tự chọn thể dục 1',
                'type' => config('subject.type.basic')
            ], [
                'name' => 'Tự chọn thể dục 2',
                'type' => config('subject.type.basic')
            ], [
                'name' => 'Tự chọn thể dục 3',
                'type' => config('subject.type.basic')
            ], [
                'name' => 'Đường lối quân sự của Đảng',
                'type' => config('subject.type.basic')
            ], [
                'name' => 'Công tác quốc phòng, an ninh',
                'type' => config('subject.type.basic')
            ], [
                'name' => 'QS chung và chiến thuật, kỹ thuật bắn súng tiểu liên AK',
                'type' => config('subject.type.basic')
            ], [
                'name' => 'Tiếng Anh',
                'type' => config('subject.type.basic')
            ], [
                'name' => 'Kỹ thuật ghép nối máy tính',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Hệ nhúng',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Quản trị dự án công nghệ thông tin',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Thiết kế IC',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Phát triển Hệ thống phần mềm doanh nghiệp',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Cơ sở văn hoá Việt Nam',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Kỹ thuật mô hình hóa và mô phỏng',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Kỹ năng ITSS học bằng tiếng Nhật 2',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Kỹ năng ITSS học bằng tiếng Nhật 1',
                'type' => config('subject.type.specialization')
            ], [
                'name' => '	Tín hiệu và hệ thống',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Quá trình ngẫu nhiên ứng dụng',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Kỹ thuật điện tử tương tự và số',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Project I',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Project II',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Project II',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Các hệ phân tán',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Kỹ thuật truyền thông điện tử',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Thiết bị truyền thông và mạng',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Cấu trúc dữ liệu và thuật toán',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Lập trình C (nâng cao)',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Toán rời rạc',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Lập trình C (cơ bản)',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Mạng máy tính',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Máy bay không người lái',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'An toàn bay',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Độ tin cậy trong kỹ thuật hàng không',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Đồ án kỹ sư (KTHK)',
                'type' => config('subject.type.specialization')
            ], [
                'name' => '	Khoa học dữ liệu ứng dụng trong kinh doanh',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Phân tích dữ liệu lớn và tri thức kinh doanh',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Hệ thống hỗ trợ ra quyết định',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'ĐA Thiết kế hệ thống CĐT',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Hệ thống CĐT trong thiết bị',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Trí tuệ nhân tạo trong Robot',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Cơ học môi trường liên tục',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Công nghệ & thiết bị hàn vảy',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Máy dập CNC, PLC',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Thiết kế và chế tạo khuôn',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'ĐA Thiết kế công nghệ và chế tạo khuôn dập tạo hình',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Dung sai lắp ghép',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Tổ chức sản xuất cơ khí',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Đồ án thiết kế hệ thống đo lường cơ khí',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Kỹ thuật Laser',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Thiết kế hệ thống quang điện tử',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Khai phá Web',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Chuyên đề',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Thực tập kỹ sư',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Đồ án kỹ sư',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Tin sinh học',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Phát triển phần mềm nhúng thông minh',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Công nghệ nhận dạng và tổng hợp tiếng nói',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Đồ án thiết kế Kỹ thuật máy tính',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Blockchain và ứng dụng',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Luyện kim vật lý',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Đồ án: Lựa chọn vật liệu',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Công nghệ vật liệu cấu trúc nano',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Mô hình hóa và mô phỏng vật liệu',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Công nghệ vật liệu tiên tiến',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Tính năng vật liệu trong các môi trường đặc biệt',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Cơ sở tính toán máy hóa chất',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Đồ án thiết kế máy và thiết bị công nghiệp hóa chất',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Thiết kế thiết bị điện hóa',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Hoá học polyme y sinh',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Hoá học silicon',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Tin học và Tự động hóa trong công nghiệp',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Thiết kế hệ thống có kết nối nhiệt',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Chuyên đề Máy và thiết bị công nghiệp hóa chất',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Thí nghiệm chuyên ngành máy và thiết bị công nghiệp hoá chất',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Công nghệ chế tạo máy II',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Đồ án thiết kế máy',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Công nghệ tạo hình dụng cụ',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Đồ án công nghệ chế tạo máy',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Kỹ thuật ma sát',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Giải phẫu học sinh lý đại cương',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Hệ thống công nghệ quá trình may',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Kỹ thuật môi trường trong công nghiệp',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Vật liệu kỹ thuật',
                'type' => config('subject.type.specialization')
            ], [
                'name' => 'Thiết kế chi tiết máy',
                'type' => config('subject.type.specialization')
            ],
        ];

        $faker = Faker\Factory::create();
        foreach ($departments as $department) {
            $departmentInstance = Department::create([
                'name' => $department['name'],
            ]);
            foreach ($department['specializations'] as $specialization) {
                Specialization::create([
                    'name' => $specialization,
                    'department_id' => $departmentInstance->id,
                    'min_credit' => 30,
                ]);
            }
        }
        foreach ($subjects as $subject) {
            Subject::create([
                'name' => $subject['name'],
                'type' => $subject['type'],
                'semester' => $subject['type'] == config('subject.type.basic')
                    ? $faker->randomElement(
                        range(
                            config('config.start_semester'),
                            config('config.class_register_limit_semester')
                        )
                    ) : null,
                'credit' => rand(1, 3),
                'department_id' => $faker->randomElement(
                    Department::all()->pluck('id')->toArray()
                ),
            ]);
        }
        Specialization::all()->each(function ($specialization) use ($faker) {
            $subjects = [];
            foreach (Subject::whereType(config('subject.type.basic'))
                ->get()
                ->pluck('id')
                ->toArray()
                as $subject) {
                $subjects[$subject] =  [
                    'force' => config('subject.force'),
                    'semester' => $faker->randomElement(
                        range_semester(config('config.start_semester'), config('config.class_register_limit_semester'), false)
                    )
                ];
            }
            $specialization->subjects()->attach($subjects);
            $subjects = [];
            foreach ($faker->randomElements(
                Subject::whereType(config('subject.type.specialization'))
                    ->get()
                    ->pluck('id')
                    ->toArray(),
                8
            ) as $subject) {
                $force = $faker->randomElement([0, 1]);
                $subjects[$subject] = [
                    'force' => $force,
                    'semester' => $force ? null : $faker->randomElement(
                        range(
                            config('config.student_register_start_semester'),
                            config('config.max_semester')
                        )
                    ),
                ];
            }
            $specialization->subjects()->attach($subjects);
        });
    }
}
