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
        foreach (config('config.roles') as $key => $role) {
            Role::create([
                'name' => $role['name'],
                'guard_name' => $role['guard'],
                'display_name' => $role['display_name'],
            ]);
        }

        Role::findById(1, config('config.roles.super_admin.guard'))
            ->givePermissionTo(range(0, count(config('config.permissions'))));
    }
}
