<?php

use Illuminate\Support\Facades\Route;

Route::group(['as' => 'admin.'], function () {
    Route::group(['middleware' => 'auth:manager'], function () {
        Route::get('', 'HomeController@index')
            ->name('home');

        Route::resource('subjects', 'SubjectController')
            ->except('show');

        Route::resource('teachers', 'TeacherController')
            ->except('show');

        Route::resource('managers', 'ManagerController')
            ->except('show');

        Route::get('teachers/{id}/change-department', 'TeacherController@changeDepartmentShow')
            ->name('teachers.change_department_show');

        Route::put('teachers/{id}/change-department', 'TeacherController@changeDepartment')
            ->name('teachers.change_department');

        Route::get('teachers/{id}/choose-subject', 'TeacherController@chooseSubjectShow')
            ->name('teachers.choose_subject_show');

        Route::put('teachers/{id}/choose-subject', 'TeacherController@chooseSubject')
            ->name('teachers.choose_subject');

        Route::resource('schedules', 'ScheduleController')
            ->only(['index', 'create', 'destroy']);

        Route::post('schedules/{id}/teacher', 'ScheduleController@setTeacher')
            ->name('schedules.teacher');

        Route::post('schedules/{id}/start', 'ScheduleController@startSchedule')
            ->name('schedules.start');

        Route::post('schedules/store', 'ScheduleController@store')
            ->name('schedules.register');

        // Route::get('schedules/{id}/choose-time', 'ScheduleController@scheduleTimeShow')
        //     ->name('schedules.scheduleTimeShow');

        // Route::post('schedules/{id}/choose-time', 'ScheduleController@scheduleTime')
        //     ->name('schedules.scheduleTime');

        Route::get('schedules/students', 'ScheduleStudentController@index')
            ->name('schedules.students.index');


        Route::get('schedules/students/{id}', 'ScheduleStudentController@registerScheduleShow')
            ->name('schedules.students.registerScheduleShow');

        Route::post('schedules/students/{id}', 'ScheduleStudentController@registerSchedule')
            ->name('schedules.students.registerSchedule');

        Route::post('schedules/students/{id}/status', 'ScheduleStudentController@creditStatus')
            ->name('schedules.students.creditStatus');

        Route::get('schedules/class', 'ScheduleClassController@index')
            ->name('schedules.classes.index');

        Route::get('schedules/class/{id}/credit', 'ScheduleClassController@showListCredits')
            ->name('schedules.classes.showListCredits');

        Route::get('schedules/class/{id}', 'ScheduleClassController@registerScheduleShow')
            ->name('schedules.classes.registerScheduleShow');

        Route::post('schedules/class/{id}', 'ScheduleClassController@registerSchedule')
            ->name('schedules.classes.registerSchedule');

        Route::resource('specializations', 'SpecializationController');

        Route::post('specializations/{id}/restore', 'SpecializationController@restore')
            ->name('specializations.restore');

        Route::get('specializations/{id}/choose-subject', 'SpecializationController@chooseSubjectShow')
            ->name('specializations.choose_subject_show');

        Route::post('specializations/{id}/choose-subject', 'SpecializationController@chooseSubject')
            ->name('specializations.choose_subject');

        Route::resource('classes', 'ClassController')
            ->except('show');

        Route::get('classes/{id}/students', 'ClassController@studentsShow')
            ->name('classes.students');

        Route::post('classes/{id}/remove-student', 'ClassController@removeStudent')
            ->name('classes.remove_student');

        Route::resource('grades', 'GradeController');

        Route::post('grades/{id}/credit-status', 'GradeController@registerCreditStatus')
            ->name('grades.creditStatus');

        Route::resource('departments', 'DepartmentController');

        Route::resource('students', 'StudentController')
            ->except('show');

        Route::group(['prefix' => 'requests', 'as' => 'requests.'], function () {
            Route::get('', 'RequestController@index')
                ->name('index');

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

    Route::get('logout', 'LoginController@logout')
        ->name('logout');
});
