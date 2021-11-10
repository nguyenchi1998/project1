<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = config('role.roles');
        array_shift($roles);
        foreach ($roles as $key => $value) {
            foreach (config('role.permissions') as $key => $permission) {
                Permission::create([
                    'name' => $permission['name'],
                    'display_name' => $permission['display_name'],
                    'guard_name' => $value['guard'],
                ]);
            }
        }
    }
}
