<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route Auth
Route::post('/login', 'Api\\AuthController@login');
Route::post('/register', 'Api\\AuthController@register');



Route::post('/search', 'HomeController@search');

// Route Home
Route::group(['prefix' => 'home'], function () {
    Route::get('/', 'Api\\HomeController@index');
    Route::get('/{id}', 'Api\\HomeController@show');
    Route::get('/category/{category_id}', 'Api\\HomeController@showCategory');
});


// middleware jwt
Route::group(['middleware' => ['jwt.verify']], function () {
    // Route Seller
    Route::get('/shop', 'Api\\SellerController@shop');
    Route::post('/create_shop', 'Api\\SellerController@createShop');
    Route::post('/store_product', 'Api\SellerController@store');
});
