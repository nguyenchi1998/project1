<?php

use App\Models\Manager;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/** @var Factory $factory */
/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Manager::class, function (Faker $faker) {
    $path = $faker->image(
        storage_path(config('default.path.app_public')),
        config('default.avatar_size'),
        config('default.avatar_size')
    );

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'gender' => $faker->numberBetween(0, 1),
        'birthday' => $faker->date,
        'phone' => $faker->phoneNumber,
        'password' => Hash::make(config('default.auth.password')),
        'remember_token' => str_random(10),
        'address' => $faker->address(),
        'type' => config('role.manager.normal'),
        'avatar' => str_replace(storage_path(config('default.path.app_public')), '', $path), 
        'uuid' => Str::uuid(),
    ];
});
