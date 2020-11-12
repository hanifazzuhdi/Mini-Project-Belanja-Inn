<?php

use Illuminate\Database\Seeder;
use App\Category;
use App\Product;
use App\Role;
use App\Shop;
use App\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
    ` */
    public function run()
    {
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
            'category_name' => 'Pakaian'
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

        User::create([
            'name' => 'mujahid',
            'email' => 'mujahid@gmail.com',
            'password' => Hash::make('password')
        ]);

        User::create([
            'name' => 'fauzil',
            'email' => 'fauzil@gmail.com',
            'password' => Hash::make('password')
        ]);

        Shop::create([
            'id' => 1,
            'shop_id' => 1,
            'shop_name' => 'mujahid shop',
            'avatar' => 'sample.png',
            'address' => 'jakarta indonesia',
            'description' => 'ini adalah toko milik mujahid'
        ]);

        Shop::create([
            'id' => 2,
            'shop_id' => 2,
            'shop_name' => 'fauzil shop',
            'avatar' => 'sample.png',
            'address' => 'palembang indonesia',
            'description' => 'ini adalah toko milik fauzil'
        ]);

        Product::create([
            'product_name' => 'energen rasa milo',
            'price' => '15.000',
            'quantity' => 10,
            'description' => 'ini adalah energen rasa milo',
            'image' => 'sample.png',
            'weight' => '1kg',
            'sold' => 10,
            'shop_id' => 2,
            'category_id' => 1
        ]);

        Product::create([
            'product_name' => 'energen rasa Pisang',
            'price' => '19.000',
            'quantity' => 10,
            'description' => 'ini adalah energen rasa pisang',
            'image' => 'sample.png',
            'weight' => '10kg',
            'sold' => 100,
            'shop_id' => 1,
            'category_id' => 4
        ]);
    }
}
