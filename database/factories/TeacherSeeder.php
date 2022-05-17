<?php

/** @var Factory $factory */

use App\Model;
use App\Models\Teacher;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Teacher::class, function (Faker $faker) {
    $path = $faker->image(
        realpath(storage_path(config('default.path.app_public'))),
        config('default.avatar_size'),
        config('default.avatar_size')
    );

    return [
        'name' => $faker->name,
        'avatar' => str_replace(realpath(storage_path(config('default.path.app_public'))), '', $path),
        'email' => $faker->unique()->safeEmail,
        'gender' => $faker->numberBetween(0, 1),
        'birthday' => $faker->date,
        'phone' => $faker->phoneNumber,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
        'address' => $faker->address(),
    ];
});
