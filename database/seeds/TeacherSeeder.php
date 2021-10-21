<?php

use App\Models\Department;
use App\Models\Media;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        if (!file_exists(('storage/app/public' . config('default.path.media.avatar.teacher')))) {
            mkdir('storage/app/public' . config('default.path.media.avatar.teacher'), 777, true);
        }
        $path = $faker->image('storage/app/public' . config('default.path.media.avatar.teacher'), 200, 200);
        $teacher = Teacher::create([
            'name' => 'Teacher Chi',
            'gender' => 1,
            'birthday' => Carbon::now(),
            'email' => 'teacher@gmail.com',
            'password' => Hash::make(config('default.auth.password')),
            'address' => $faker->address(),
        ]);
        $media = Media::create([
            'path' => 'storage/' . str_replace('storage/app/public/', '', $path),
        ]);
        $teacher->avatar()->save($media);
        $teacherRole = Role::findByName(config('common.roles.teacher.name'), 'teacher');
        $teacher->assignRole($teacherRole);
        $departmentIds = Department::all()->pluck('id')->toArray();
        factory(Teacher::class, 5)->create()->each(function ($teacher) use ($teacherRole, $departmentIds, $path) {
            $media = Media::create([
                'path' => 'storage/' . str_replace('storage/app/public/', '', $path),
            ]);
            $teacher->avatar()->save($media);
            $teacher->assignRole($teacherRole);
            $teacher->update([
                'department_id' => $departmentIds[array_rand($departmentIds)]
            ]);
        });
    }
}
