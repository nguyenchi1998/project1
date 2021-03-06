<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'Admin'], function () {
    Route::group(['middleware' => ['jwt.verify', 'auth.jwt', 'access:manager']], function () {
        Route::apiResource('managers', 'ManagerController');
        Route::apiResource('students', 'StudentController');
        Route::apiResource('teachers', 'TeacherController');
        Route::apiResource('subjects', 'SubjectController');
        Route::apiResource('classes', 'ClassController');
        Route::apiResource('specializations', 'SpecializationController');
        Route::apiResource('departments', 'DepartmentController');
        Route::apiResource('grades', 'GradeController');
        Route::apiResource('schedules.details', 'ScheduleController');
    });
    Route::group(['prefix' => 'manager'], function () {
        Route::group(['prefix' => 'auth',], function () {
            Route::post('login', 'LoginController@login');
            Route::post('logout', 'LoginController@logout');
            Route::get('profile', 'LoginController@profile');
        });
    });
});

Route::group(['namespace' => 'Teacher'], function () {
    Route::group(['prefix' => 'teacher','access:teacher'], function () {
        Route::group(['prefix' => 'auth'], function () {
            Route::post('login', 'LoginController@login');
            Route::post('logout', 'LoginController@logout');
            Route::get('profile', 'LoginController@profile');
        });
    });
});

Route::group(['namespace' => 'Student'], function () {
    Route::group(['prefix' => 'student','access:student'], function () {
        Route::group(['prefix' => 'auth'], function () {
            Route::post('login', 'LoginController@login');
            Route::post('logout', 'LoginController@logout');
            Route::get('profile', 'LoginController@profile');
        });
    });
});

