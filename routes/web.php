<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'CekAdmin', 'auth'], function () {
    Route::get('/dashboard', 'HomeController@index')->name('home');
});
