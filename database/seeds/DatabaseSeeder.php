<?php

use Illuminate\Database\Seeder;
use App\Category;
use App\Product;
use App\Role;
use App\Shop;
use App\User;
use Faker\Factory as Faker;
use Illuminate\Support\Str;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
    ` */
    public function run()
    {
        $faker =  Faker::create();

        Category::create([
            'category_name' => 'Elektronik'
        ]);

        Category::create([
            'category_name' => 'Komputer dan Aksesoris'
        ]);

        Category::create([
            'category_name' => 'Handphone dan Aksesoris'
        ]);

        Category::create([
            'category_name' => 'Perlengkapan Rumah'
        ]);

        Role::create([
            'role_name' => 'user'
        ]);

        Role::create([
            'role_name' => 'admin'
        ]);

        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'phone_number' => $faker->phoneNumber,
                'remember_token' => Str::random(10),
            ]);
        }

        for ($i = 1; $i <= 3; $i++) {
            Shop::create([
                'shop_id' => $faker->numberBetween(1, 5),
                'shop_name' => $faker->company,
                'avatar' => 'https://via.placeholder.com/150',
                'address' => $faker->address,
                'description' => $faker->sentence
            ]);
        }

        for ($i = 1; $i <= 15; $i++) {
            Product::create([
                'product_name' => $faker->state,
                'price' => $faker->numberBetween(1000, 200000),
                'quantity' => $faker->numberBetween(1, 50),
                'description' => $faker->sentence,
                'image' => 'https://via.placeholder.com/150',
                'sub_image1' => 'https://via.placeholder.com/150',
                'sub_image2' => 'https://via.placeholder.com/150',
                'category_id' => $faker->numberBetween(1, 4),
                'shop_id' => $faker->numberBetween(1, 3)
            ]);
        }
    }
}
