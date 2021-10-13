<?php

use Illuminate\Support\Facades\Route;

Route::group(['as' => 'admin.'], function () {
    Route::group(['middleware' => 'auth:admin'], function () {
        Route::get('', 'HomeController@index')->name('home');
        Route::resource('subjects', 'SubjectController');
        Route::resource('roles', 'RoleController');
        Route::resource('specializations', 'SpecializationController');
        Route::resource('classes', 'ClassController');
    });
    Route::get('login', 'LoginController@showLoginForm')
        ->name('loginShow');
    Route::post('login', 'LoginController@login')
        ->name('login');
});

