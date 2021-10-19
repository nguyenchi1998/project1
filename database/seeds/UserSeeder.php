<?php

use App\Models\Media;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        if (
            !file_exists(
                (
                    'storage/app/public' . config('default.path.media.avatar.teacher')
                )
            )
        ) {
            mkdir('storage/app/public' . config('default.path.media.avatar.teacher'), 777, true);
        }
        $path = $faker->image('storage/app/public' . config('default.path.media.avatar.teacher'), 200, 200);
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'gender' => 1,
            'birthday' => Carbon::now(),
            'email' => 'admin@gmail.com',
            'password' => Hash::make(config('default.auth.password')),
            'address' => $faker->address(),
        ]);
        $media = Media::create([
            'path' => 'storage/' . str_replace('storage/app/public/', '', $path),
        ]);
        $superAdmin->avatar()->save($media);
        $superAdminRole = Role::findByName(config('common.roles.superAdmin.name'), 'admin');
        $adminRole = Role::findByName(config('common.roles.admin.name'), 'admin');
        $teacherRole = Role::findByName(config('common.roles.teacher.name'), 'admin');
        $superAdmin->assignRole($superAdminRole);
        factory(User::class, 2)->create()->each(function ($user) use ($adminRole, $path) {
            $media = Media::create([
                'path' => 'storage/' . str_replace('storage/app/public/', '', $path),
            ]);
            $user->avatar()->save($media);
            $user->assignRole($adminRole);
        });
        $departmentIds = \App\Models\Department::all()->pluck('id')->toArray();
        factory(User::class, 10)->create()->each(function ($user) use ($teacherRole, $departmentIds, $path) {
            $media = Media::create([
                'path' => 'storage/' . str_replace('storage/app/public/', '', $path),
            ]);
            $user->avatar()->save($media);
            $user->assignRole($teacherRole);
            $user->update(['department_id' => $departmentIds[array_rand($departmentIds)]]);
        });
    }
}
