<?php

use Illuminate\Support\Facades\Route;

Route::group(['as' => 'teacher.'], function () {
    Route::group(['middleware' => 'auth:teacher'], function () {
        Route::get('', 'HomeController@index')
            ->name('home');

        Route::get('schedules', 'ScheduleController@index')
            ->name('schedules.index');

        Route::get('schedules/{id}/attendance', 'ScheduleController@attendanceShow')
            ->name('schedules.attendanceShow');

        Route::get('schedules/{id}/mark', 'ScheduleController@markShow')
            ->name('schedules.markShow');

        Route::post('schedules/{id}/mark', 'ScheduleController@mark')
            ->name('schedules.mark');
    });

    Route::get('login', 'LoginController@showLoginForm')
        ->name('loginShow');

    Route::post('login', 'LoginController@login')
        ->name('login');

    Route::post('logout', 'LoginController@logout')
        ->name('logout');
});
