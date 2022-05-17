<?php

use App\Models\Manager;
use App\Models\Media;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $path = $faker->image(
            realpath(storage_path(config('default.path.app_public'))),
            config('default.avatar_size'),
            config('default.avatar_size')
        );
        Manager::create([
            'name' => 'Super Admin',
            'avatar' => str_replace(realpath(storage_path(config('default.path.app_public'))), '', $path),
            'gender' => 1,
            'birthday' => Carbon::now(),
            'email' => 'admin@gmail.com',
            'password' => Hash::make(config('default.auth.password')),
            'address' => $faker->address(),
            'type' => config('role.manager.super')
        ]);

        factory(Manager::class, 2)->create();
    }
}
