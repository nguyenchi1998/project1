<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes([]);

Route::group(['middleware' => 'auth:student'], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::resource('credits', 'CreditController')->only(['index', 'create', 'store', 'destroy']);
    Route::resource('marks', 'MarkController')->only(['index']);
});
