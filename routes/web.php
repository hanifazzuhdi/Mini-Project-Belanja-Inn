<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'CekAdmin', 'auth'], function () {
    // main
    Route::get('/dashboard', 'HomeController@index')->name('home');
    Route::get('/getUser', 'HomeController@getUser')->name('getUser');
    Route::get('/detailUser/{id}', 'HomeController@getDetail')->name('detailUser');
    Route::put('/updateUser/{id}', 'HomeController@update')->name('update');
    Route::delete('/delete/{id}', 'HomeController@destroy');

    Route::get('/settings/category', 'HomeController@category')->name('category');
});
