<?php

use App\Cart;
use App\Role;
use App\Shop;
use App\User;
use App\Order;
use App\Product;
use App\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
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
            'role_name' => 'penjual'
        ]);

        Role::create([
            'role_name' => 'admin'
        ]);

        User::create([
            'name' => 'mujahid',
            'username' => 'mujahid01',
            'email' => 'mujahid@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => 2
        ]);

        User::create([
            'name' => 'fauzil',
            'username' => 'fauzil01',
            'email' => 'fauzil@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => 2
        ]);

        User::create([
            'name' => 'faiz',
            'username' => 'faiz01',
            'email' => 'faiz@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => 2
        ]);

        User::create([
            'name' => 'Hanif',
            'username' => 'hanif',
            'email' => 'hanif@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => 3
        ]);

        User::create([
            'name' => 'Usman',
            'username' => 'usman',
            'email' => 'usman@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => 1
        ]);

        Shop::create([
            'id' => 1,
            'user_id' => 1,
            'shop_name' => 'mujahid shop',
            'avatar' => 'https://via.placeholder.com/150',
            'address' => 'jakarta indonesia',
            'description' => 'ini adalah toko milik mujahid'
        ]);

        Shop::create([
            'id' => 2,
            'user_id' => 2,
            'shop_name' => 'fauzil shop',
            'avatar' => 'https://via.placeholder.com/150',
            'address' => 'padang indonesia',
            'description' => 'ini adalah toko milik fauzil'
        ]);

        Shop::create([
            'id' => 3,
            'user_id' => 3,
            'shop_name' => 'faiz shop',
            'avatar' => 'https://via.placeholder.com/150',
            'address' => 'papua indonesia',
            'description' => 'ini adalah toko milik faiz'
        ]);


        Product::create([
            'product_name' => 'Energen rasa milo',
            'price' => 150000,
            'quantity' => 10,
            'description' => 'ini adalah energen rasa milo',
            'image' => 'https://via.placeholder.com/150',
            'weight' => '1kg',
            'sold' => 0,
            'shop_id' => 2,
            'category_id' => 1
        ]);

        Product::create([
            'product_name' => 'Energen rasa Pisang',
            'price' => 19000,
            'quantity' => 10,
            'description' => 'ini adalah energen rasa pisang',
            'image' => 'https://via.placeholder.com/150',
            'weight' => '10kg',
            'sold' => 0,
            'shop_id' => 1,
            'category_id' => 4
        ]);

        Product::create([
            'product_name' => 'Energen rasa Kopi Hitam',
            'price' => 20000,
            'quantity' => 10,
            'description' => 'ini adalah energen rasa Kopi',
            'image' => 'https://via.placeholder.com/150',
            'weight' => '10kg',
            'sold' => 0,
            'shop_id' => 2,
            'category_id' => 4
        ]);
    }
}
