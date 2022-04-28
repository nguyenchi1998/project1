<?php

/** @var Factory $factory */

use App\Models\Student;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

$factory->define(Student::class, function (Faker $faker) {
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
        'password' => Hash::make('123456'),
        'remember_token' => str_random(10),
        'address' => $faker->address(),
        'avatar' => str_replace(storage_path(config('default.path.app_public')), '', $path),
        'uuid' => Str::uuid(),
    ];
});
