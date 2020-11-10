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
    Route::get('/get_shop/{id}', 'Api\\SellerController@shop')->name('get_shop');
    Route::post('/create_shop', 'Api\\SellerController@createShop')->name('create_shop');

    // Route crud Seller
    Route::post('/store_product', 'Api\SellerController@storeProduct')->name('store_product');
    Route::post('/update_product/{id}', 'Api\SellerController@updateProduct')->name('update_product');
});
