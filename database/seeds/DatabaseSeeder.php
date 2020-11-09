<?php

use Illuminate\Database\Seeder;
use App\Category;
use App\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
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
            'category_name' => 'Perlengkapan Rumah'
        ]);

        Role::create([
            'role_name' => 'user'
        ]);

        Role::create([
            'role_name' => 'admin'
        ]);
    }
}
