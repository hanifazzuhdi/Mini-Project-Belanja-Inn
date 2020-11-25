<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function category()
    {
        $categories = Category::get();

        return view('pages.settings.category', compact('categories'));
    }

    public function storeAccount()
    {
        return view('pages.settings.storeAccount');
    }

    public function store(Request $request)
    {
    }
}
