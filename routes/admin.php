<?php

use Illuminate\Support\Facades\Route;

Route::group(['as' => 'admin.'], function () {
    Route::group(['middleware' => 'auth:admin'], function () {
        Route::get('', 'HomeController@index')->name('home');
        Route::resource('subjects', 'SubjectController');
        Route::resource('teachers', 'TeacherController');
        Route::get('teachers/{id}/change-department', 'TeacherController@changeDepartmentShow')
            ->name('teachers.change_department_show');
        Route::put('teachers/{id}/change-department', 'TeacherController@changeDepartment')
            ->name('teachers.change_department');
        Route::resource('schedules', 'ScheduleController');
        Route::resource('roles', 'RoleController');
        Route::resource('specializations', 'SpecializationController');
        Route::resource('classes', 'ClassController');
        Route::resource('grades', 'GradeController');

        Route::group(['prefix' => 'request', 'as' => 'requests.'], function () {
            Route::get('', 'RequestController@index')->name('index');
            Route::post('/departments/approve', 'RequestController@approveDepartmentChange')
                ->name('departments.approve');
            Route::post('/departments/reject', 'RequestController@approveDepartmentChange')
                ->name('departments.reject');
        });
    });
    Route::get('login', 'LoginController@showLoginForm')
        ->name('loginShow');
    Route::post('login', 'LoginController@login')
        ->name('login');
});

