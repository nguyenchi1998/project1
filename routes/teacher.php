<?php

use Illuminate\Support\Facades\Route;

Route::group(['as' => 'teacher.'], function () {
    Route::group(['middleware' => 'auth:teacher'], function () {
        Route::get('', 'HomeController@index')
            ->name('home');
        Route::resource('subjects', 'SubjectController');
    });
    Route::get('login', 'LoginController@showLoginForm')
        ->name('loginShow');
    Route::post('login', 'LoginController@login')
        ->name('login');
    Route::post('logout', 'LoginController@logout')
        ->name('logout');
});
