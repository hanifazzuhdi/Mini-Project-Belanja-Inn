<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function category()
    {
        $categories = Category::all()->toArray();

        return view("pages.category", compact('categories'));
    }
}
