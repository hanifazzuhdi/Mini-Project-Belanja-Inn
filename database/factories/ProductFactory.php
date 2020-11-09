<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'product_name' => $faker->state,
        'price' => $faker->numberBetween(1000, 200000),
        'quantity' => $faker->numberBetween(1, 50),
        'description' => $faker->sentence,
        'image' => 'https://via.placeholder.com/150',
        'sub_image1' => 'https://via.placeholder.com/150',
        'sub_image2' => 'https://via.placeholder.com/150',
        'category_id' => $faker->numberBetween(1, 4),
        'shop_id' => $faker->numberBetween(1, 3)
    ];
});
