<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'CekAdmin', 'auth'], function () {
    // Route HomeController
    Route::get('/dashboard', 'HomeController@index')->name('home');
    Route::get('/user', 'HomeController@user')->name('user');
    Route::get('/product', 'HomeController@product')->name('product');

    Route::get('/detailUser/{id}', 'HomeController@getDetail')->name('detailUser');                     // <== Detail
    Route::get('/detailProduct/{id}', 'HomeController@getProductDetail')->name('detailProduct');
    Route::get('/detailHistory/{id}', 'HomeController@getHistory')->name('detailHistory');

    Route::put('/updateUser/{id}', 'HomeController@update')->name('update');                            // <== Update
    Route::put('/updateAvatar/{id}', 'HomeController@updateAvatar')->name('updateAvatar');
    Route::delete('/delete/{id}', 'HomeController@destroy');
    Route::delete('/deleteProduct/{id}', 'HomeController@destroyProduct');

    // Route Settings
    Route::get('/settings/category', 'SettingController@category')->name('category');
    Route::get('/settings/admins', 'SettingController@admins')->name('admins');
    // Route::get('/settings/storeAccount', 'SettingController@storeAccount')->name('storeAccount');
    Route::post('/settings/storeAccount', 'SettingController@store')->name('store');
});

// Route Fallback
Route::fallback(function () {
    return view('404');
});


/*  Goals

1. Settings :
    - Category
    - Create Account role  = 3
    - Delete Account

2. Notification
3. Pusat Bantuan

*/
