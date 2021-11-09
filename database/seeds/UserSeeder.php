<?php

use App\Models\Department;
use App\Models\Media;
use App\Models\Teacher;
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
        $path = $faker->image(storage_path(config('default.path.app_public')), config('default.avatar_size'), config('default.avatar_size'));
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'gender' => 1,
            'birthday' => Carbon::now(),
            'email' => 'admin@gmail.com',
            'password' => Hash::make(config('default.auth.password')),
            'address' => $faker->address(),
        ]);
        $media = Media::create([
            'path' => str_replace(storage_path(config('default.path.app_public')), '', $path),
        ]);
        $superAdmin->avatar()->save($media);
        $superAdminRole = Role::findByName(config('config.roles.super_admin.name'), config('config.roles.admin.name'));
        $adminRole = Role::findByName(config('config.roles.admin.name'), 'admin');
        $superAdmin->assignRole($superAdminRole);
        factory(User::class, 2)->create()->each(function ($user) use ($adminRole, $path) {
            $media = Media::create([
                'path' => str_replace(storage_path(config('default.path.app_public')), '', $path),
            ]);
            $user->avatar()->save($media);
            $user->assignRole($adminRole);
        });
    }
}
