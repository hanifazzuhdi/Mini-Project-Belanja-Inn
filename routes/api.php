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
    Route::post('/filter_search', 'Api\\PublicController@filterSearch');
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

    //Route order
    Route::post('/order_product/{id}', 'Api\\OrderController@order')->name('order_product');
    Route::get('/carts', 'Api\\OrderController@carts')->name('carts');
    Route::delete('/delete_cart/{id}', 'Api\\OrderController@delete')->name('delete_cart');
    Route::put('/update_cart/{id}', 'Api\\OrderController@updateCart')->name('update_cart');

    // Route transaksi
    Route::get('/getCheckout', 'Api\\TransactionController@getCheckout')->name('getCheckout');
    Route::post('/checkout', 'Api\TransactionController@checkout');
    Route::get('/getDikemas', 'Api\TransactionController@getDikemas');
});
