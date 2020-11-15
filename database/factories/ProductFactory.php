<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Factory;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    $faker = Factory::create('id_ID');

    return [
        'product_name' => $faker->state,
        'price' => $faker->numberBetween(1000, 200000),
        'quantity' => $faker->numberBetween(1, 50),
        'description' => $faker->realText(100),
        'image' => 'https://via.placeholder.com/150',
        'weight' => $faker->numberBetween(1, 50),
        'sold' => $faker->numberBetween(1, 50),
        'category_id' => $faker->numberBetween(1, 4),
        'shop_id' => $faker->numberBetween(1, 3)
    ];
});
