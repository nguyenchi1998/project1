<?php

use App\Models\Specialization;
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
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'gender' => 1,
            'birthday' => Carbon::now(),
            'email' => 'admin@gmail.com',
            'password' => Hash::make(config('default.auth.password'))
        ]);
        $superAdminRole = Role::findByName(config('common.roles.superAdmin.name'), 'admin');
        $adminRole = Role::findByName(config('common.roles.admin.name'), 'admin');
        $teacherRole = Role::findByName(config('common.roles.teacher.name'), 'admin');
        $superAdmin->assignRole($superAdminRole);
        factory(User::class, 2)->create()->each(function ($user) use ($adminRole) {
            $user->assignRole($adminRole);
        });
        $departmentIds = \App\Models\Department::all()->pluck('id')->toArray();
        factory(User::class, 10)->create()->each(function ($user) use ($teacherRole, $departmentIds) {
            $user->assignRole($teacherRole);
            $user->update(['department_id' => $departmentIds[array_rand($departmentIds)]]);
        });
    }
}
