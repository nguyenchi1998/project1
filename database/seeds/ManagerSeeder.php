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
        $path = $faker->image(storage_path(config('default.path.app_public')), config('default.avatar_size'), config('default.avatar_size'));
        $superAdmin = Manager::create([
            'name' => 'Super Admin',
            'gender' => 1,

            'birthday' => Carbon::now(),
            'email' => 'admin@gmail.com',
            'password' => Hash::make(config('default.auth.password')),
            'address' => $faker->address(),
            'type' => config('role.manager.super')
        ]);
        $media = Media::create([
            'path' => str_replace(storage_path(config('default.path.app_public')), '', $path),
        ]);
        $superAdmin->update([
            'code' => generate_code(Manager::class, $superAdmin->id),
        ]);
        $superAdmin->avatar()->save($media);
        factory(Manager::class, 2)->create()->each(function ($manager, $key) use ($path) {
            $media = Media::create([
                'path' => str_replace(storage_path(config('default.path.app_public')), '', $path),
            ]);
            $manager->update(['code' => generate_code(Manager::class, $manager->id)]);
            $manager->avatar()->save($media);
        });
    }
}
