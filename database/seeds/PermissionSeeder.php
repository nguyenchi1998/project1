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
        $actions = ['list', 'show', 'update', 'create', 'delete'];

        $models = ['*', 'subject', 'mark', 'student', 'admin', 'schedule'];

        foreach ($models as $model) {
            if ($model == '*') {
                Permission::create([
                    'name' => 'all',
                    'guard_name' => 'web'
                ]);
                continue;
            }
            foreach ($actions as $action) {
                Permission::create([
                    'name' => strtolower($action) . '-' . strtolower($model),
                    'guard_name' => 'web'
                ]);
            }
        }
    }
}
