<?php

use Illuminate\Support\Facades\Route;


Route::group(['as' => 'admin.'], function () {
    Route::group(['middleware' => 'auth:admin'], function () {
        Route::get('', 'HomeController@index')
            ->name('home');

        Route::resource('subjects', 'SubjectController');

        Route::resource('teachers', 'TeacherController');

        Route::resource('managers', 'ManagerController');

        Route::get('teachers/{id}/change-department', 'TeacherController@changeDepartmentShow')
            ->name('teachers.change_department_show');

        Route::put('teachers/{id}/change-department', 'TeacherController@changeDepartment')
            ->name('teachers.change_department');

        Route::get('teachers/{id}/choose-subject', 'TeacherController@chooseSubjectShow')
            ->name('teachers.choose_subject_show');

        Route::put('teachers/{id}/choose-subject', 'TeacherController@chooseSubject')
            ->name('teachers.choose_subject');

        Route::resource('schedules', 'ScheduleController')->only(['index']);

        Route::get('schedules/register/{id}', 'ScheduleController@registerScheduleShow')
            ->name('schedules.registerShow');

        Route::post('schedules/register/{id}', 'ScheduleController@registerSchedule')
            ->name('schedules.register');

        Route::resource('roles', 'RoleController');

        Route::resource('specializations', 'SpecializationController');

        Route::resource('classes', 'ClassController');

        Route::resource('grades', 'GradeController');

        Route::resource('schedules', 'ScheduleController');

        Route::resource('departments', 'DepartmentController');

        Route::resource('students', 'StudentController');

        Route::group(['prefix' => 'requests', 'as' => 'requests.'], function () {
            Route::get('', 'RequestController@index')
                ->name('index');

            Route::post('/departments/approve', 'RequestController@approveDepartmentChange')
                ->name('departments.approve');

            Route::post('/departments/reject', 'RequestController@approveDepartmentChange')
                ->name('departments.reject');
        });

        Route::resource('schedules/credits/students/','ScheduleStudentController', ['names' => 'schedules.credits.students']);
    });

    Route::get('login', 'LoginController@showLoginForm')
        ->name('loginShow');

    Route::post('login', 'LoginController@login')
        ->name('login');

    Route::post('logout', 'LoginController@logout')
        ->name('logout');
});
    
