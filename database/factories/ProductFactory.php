<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {

    return [
        'product_name' => $faker->word,
        'price' => $faker->numberBetween(1000, 500000),
        'quantity' => $faker->numberBetween(1, 50),
        'description' => $faker->realText(100),
        'image' => 'https://via.placeholder.com/150',
        'weight' => $faker->numberBetween(1, 50),
        'sold' => $faker->numberBetween(1, 50),
        'shop_id' => $faker->numberBetween(1, 4),
        'category_id' => $faker->numberBetween(1, 4),
        'created_at' => $faker->dateTimeThisYear
    ];
});
