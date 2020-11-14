<?php

use Illuminate\Support\Facades\Route;

// Route Auth
Route::post('/login', 'Api\\AuthController@login');
Route::post('/register', 'Api\\AuthController@register');

// Route Public
Route::group(['prefix' => 'public'], function () {
    Route::get('/', 'Api\\PublicController@index');
    Route::get('/{id}', 'Api\\PublicController@show');
    Route::get('/category/{category_id}', 'Api\\PublicController@showCategory');
    Route::post('/search', 'Api\\PublicController@search');
});

Route::get('/get_shop/{id}', 'Api\\ShopController@index')->name('get_shop');

// Middleware Jwt
Route::group(['middleware' => ['jwt.verify']], function () {

    Route::post('/logout', 'Api\AuthController@logout');

    // Route User
    Route::get('/get_user', 'Api\\UserController@getUserAuth')->name('get_user');
    Route::put('/update_user', 'Api\\UserController@update')->name('update_user');

    // Route Shop
    Route::post('/store_shop', 'Api\\ShopController@store')->name('store_shop');
    Route::put('/update_shop/{id}', 'Api\ShopController@update')->name('update_shop');

    // Route crud Seller
    Route::post('/store_product', 'Api\\SellerController@store')->name('store_product');
    Route::put('/update_product/{id}', 'Api\\SellerController@update')->name('update_product');
    Route::delete('/destroy_product/{id}', 'Api\SellerController@destroy')->name('destroy');

    // Route transaksi

});
