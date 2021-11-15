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
        $guards = config('role.guard');
        foreach ($guards as $guard) {
            foreach (config('role.permissions') as $key => $permission) {
                Permission::create([
                    'name' => $permission['name'],
                    'display_name' => $permission['display_name'],
                    'guard_name' => $guard,
                ]);
            }
        }
    }
}
