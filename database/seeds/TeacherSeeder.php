<?php

use App\Models\Department;
use App\Models\Media;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
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
        $path = $faker->image(storage_path(config('default.path.app_public')), 35, 35);
        $teacher = Teacher::create([
            'name' => 'Teacher Chi',
            'gender' => 1,
            'birthday' => Carbon::now(),
            'email' => 'teacher@gmail.com',
            'password' => Hash::make(config('default.auth.password')),
            'address' => $faker->address(),
        ]);
        $media = Media::create([
            'path' => str_replace(storage_path(config('default.path.app_public')), '', $path),
        ]);
        $teacher->avatar()->save($media);
        $teacherRole = Role::findByName(config('config.roles.teacher.name'), config('config.roles.teacher.name'));
        $teacher->assignRole($teacherRole);
        $teacher->update([
            'department_id' => 1,
        ]);
        $departmentIds = Department::all()->pluck('id')->toArray();
        factory(Teacher::class, 5)->create()
            ->each(function ($teacher) use ($teacherRole, $departmentIds, $path) {
                $media = Media::create([
                    'path' => str_replace(storage_path(config('default.path.app_public')), '', $path),
                ]);
                $teacher->avatar()->save($media);
                $teacher->assignRole($teacherRole);
                $teacher->update([
                    'department_id' => $departmentIds[array_rand($departmentIds)]
                ]);
            });
    }
}
