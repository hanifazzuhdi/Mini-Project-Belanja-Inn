<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Shop;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'username' => $faker->firstName() . 198,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'phone_number' => $faker->phoneNumber,
        'address' => $faker->address,
        'avatar' => 'https://via.placeholder.com/150',
        'role_id' => $faker->numberBetween(1, 3),
        'remember_token' => Str::random(10),
    ];
});

$factory->define(Shop::class, function (Faker $faker) {
    
    return [
        'id' => $faker->numberBetween(1, 10),
        // 'user_id' => $user_id,
        'shop_name' => $faker->company,
        'avatar' => 'https://via.placeholder.com/150',
        'address' => $faker->address,
        'description' => $faker->sentence
    ];
});
