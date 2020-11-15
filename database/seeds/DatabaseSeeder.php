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
            'role_id' => 3
        ]);

        User::create([
            'name' => 'fauzil',
            'username' => 'fauzil01',
            'email' => 'fauzil@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => 3
        ]);

        User::create([
            'username' => 'hanif',
            'email' => 'hanif@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => 3
        ]);

        Shop::create([
            'id' => 1,
            // 'user_id' => 1,
            'shop_name' => 'mujahid shop',
            'avatar' => 'https://iili.io/FqzDMX.md.png',
            'address' => 'jakarta indonesia',
            'description' => 'ini adalah toko milik mujahid'
        ]);

        Shop::create([
            'id' => 2,
            // 'user_id' => 2,
            'shop_name' => 'fauzil shop',
            'avatar' => 'https://iili.io/FqzDMX.md.png',
            'address' => 'palembang indonesia',
            'description' => 'ini adalah toko milik fauzil'
        ]);

        Product::create([
            'product_name' => 'energen rasa milo',
            'price' => 150000,
            'quantity' => 10,
            'description' => 'ini adalah energen rasa milo',
            'image' => 'https://iili.io/FqzDMX.md.png',
            'weight' => '1kg',
            'sold' => 10,
            'shop_id' => 2,
            'category_id' => 1
        ]);

        Product::create([
            'product_name' => 'energen rasa Pisang',
            'price' => 19000,
            'quantity' => 10,
            'description' => 'ini adalah energen rasa pisang',
            'image' => 'https://iili.io/FqzDMX.md.png',
            'weight' => '10kg',
            'sold' => 100,
            'shop_id' => 1,
            'category_id' => 4
        ]);

        Order::create([
            'user_id' => 2,
            'date' => now(),
            'status' => 0,
        ]);
        
        Order::create([
            'user_id' => 1,
            'date' => now(),
            'status' => 0,
        ]);
    
        Cart::create([
            'user_id' => 1,
            'product_id' => 2,
            'order_id' => 2,
            'quantity' => 3,
        ]);
        
        Cart::create([
            'user_id' => 1,
            'product_id' => 2,
            'order_id' => 2,
            'quantity' => 2,
        ]);
        
        Cart::create([
            'user_id' => 2,
            'product_id' => 1,
            'order_id' => 2,
            'quantity' => 10,
        ]);

    }
}
