<?php

use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

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

$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'gender' => $faker->numberBetween(0, 1),
        'birthday' => $faker->date,
        'phone' => $faker->phoneNumber,
        'password' => Hash::make(config('default.auth.password')),
        'remember_token' => str_random(10),
        'address' => $faker->address(),
    ];
});
