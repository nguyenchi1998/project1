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
        foreach (config('common.roles') as $key => $value) {
            Role::create([
                'name' => $value['name'],
                'guard_name' => $value['guard']
            ]);
        }
    }
}
