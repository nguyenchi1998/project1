<?php

use Illuminate\Support\Facades\Route;


Route::group(['as' => 'admin.'], function () {
    Route::group(['middleware' => 'auth:admin'], function () {
        Route::get('', 'HomeController@index')
            ->name('home');

        Route::resource('subjects', 'SubjectController')->except('show');

        Route::resource('teachers', 'TeacherController')->except('show');

        Route::resource('managers', 'ManagerController')->except('show');

        Route::get('teachers/{id}/change-department', 'TeacherController@changeDepartmentShow')
            ->name('teachers.change_department_show');

        Route::put('teachers/{id}/change-department', 'TeacherController@changeDepartment')
            ->name('teachers.change_department');

        Route::get('teachers/{id}/choose-subject', 'TeacherController@chooseSubjectShow')
            ->name('teachers.choose_subject_show');

        Route::put('teachers/{id}/choose-subject', 'TeacherController@chooseSubject')
            ->name('teachers.choose_subject');

        Route::resource('schedules', 'ScheduleClassController')->only(['index', 'create', 'destroy']);

        Route::post('schedules/store', 'ScheduleClassController@store')
            ->name('schedules.register');

        Route::resource('roles', 'RoleController');

        Route::resource('specializations', 'SpecializationController');

        Route::post('specializations/{id}/restore', 'SpecializationController@restore')->name('specializations.restore');

        Route::get('specializations/{id}/choose-subject', 'SpecializationController@chooseSubjectShow')
            ->name('specializations.choose_subject_show');

        Route::post('specializations/{id}/choose-subject', 'SpecializationController@chooseSubject')
            ->name('specializations.choose_subject');

        Route::resource('classes', 'ClassController');

        Route::post('classes/{id}/remove-student', 'ClassController@removeStudent')
            ->name('classes.remove_student');

        Route::post('classes/next-semester', 'ClassController@nextSemester')
            ->name('classes.next_semester');

        Route::resource('grades', 'GradeController');

        Route::resource('departments', 'DepartmentController');

        Route::resource('students', 'StudentController')->except('show');

        Route::group(['prefix' => 'requests', 'as' => 'requests.'], function () {
            Route::get('', 'RequestController@index')
                ->name('index');

            Route::post('/departments/approve', 'RequestController@approveDepartmentChange')
                ->name('departments.approve');

            Route::post('/departments/reject', 'RequestController@approveDepartmentChange')
                ->name('departments.reject');
        });

        Route::resource('schedules/credits/students/', 'ScheduleStudentController', ['names' => 'schedules.credits.students'])
            ->only('index');

        Route::get('schedules/credits/students/{id}', 'ScheduleStudentController@registerScheduleShow')
            ->name('schedules.credits.students.registerScheduleShow');

        Route::post('schedules/credits/students/{id}', 'ScheduleStudentController@registerSchedule')
            ->name('schedules.credits.students.registerSchedule');
    });

    Route::get('login', 'LoginController@showLoginForm')
        ->name('loginShow');

    Route::post('login', 'LoginController@login')
        ->name('login');

    Route::post('logout', 'LoginController@logout')
        ->name('logout');
});
