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

Route::group(['namespace' => 'Admin', 'middleware' => ['auth.guard:manager']], function () {
    Route::group(['middleware' => ['jwt.verify', 'auth.jwt']], function () {
        Route::apiResource('managers', 'ManagerController');
        Route::apiResource('students', 'StudentController');
        Route::apiResource('teachers', 'TeacherController');
    });
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', 'LoginController@login');
        Route::post('logout', 'LoginController@logout');
        Route::get('profile', 'LoginController@profile');
    });
});
