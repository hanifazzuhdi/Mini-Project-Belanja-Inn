<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/store', 'Api\\ShopController@storeShop')->name('store');
Route::post('/store_product', 'Api\\SellerController@storeProduct')->name('store_product');
Route::put('/update/product/{id}', 'Api\\SellerController@updateProduct')->name('update_product');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Docs Api
Route::get('/docs_api', function () {

    return view('docs_api');
});
