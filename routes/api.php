<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route Auth
Route::post('/login', 'Api\\AuthController@login');
Route::post('/register', 'Api\\AuthController@register');

Route::get('/shop', 'Api\\SellerController@shop');

Route::group(['middleware' => ['jwt.verify']], function () {
    // Route Seller
    Route::post('/create_shop', 'Api\\SellerController@createShop');
    Route::post('/store_product', 'Api\SellerController@store');
});

Route::get('home', 'Api\\HomeController@index');
Route::get('home/{id}', 'Api\\HomeController@show');
