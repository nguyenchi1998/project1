<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['Super Admin', 'Admin', 'Teacher', 'Student'];

        foreach ($roles as $role) {
            Role::create([
                'name' => str_replace(' ', '-', strtolower($role)),
                'guard_name' => 'web'
            ]);
        }
    }
}
