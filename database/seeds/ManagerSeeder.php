<?php

use App\Models\Manager;
use Illuminate\Database\Seeder;

class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Manager::class, 1)->create([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'type' => config('role.manager.super'),
        ]);

        factory(Manager::class, 10)->create();
    }
}
