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

        Route::get('teachers/{teacher}/choose-subject', 'TeacherController@chooseSubjectShow')
            ->name('teachers.choose_subject_show');

        Route::post('teachers/{teacher}/choose-subject', 'TeacherController@chooseSubject')
            ->name('teachers.choose_subject');

        Route::resource('schedules', 'ScheduleController')
            ->only(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy']);

        Route::post('schedules/{schedule}/export', 'ScheduleController@export')
            ->name('schedules.export');

        Route::get('student-schedules', 'ScheduleStudentController@index')
            ->name('schedules.students.index');

        Route::get('student-schedules/{student}/credit', 'ScheduleStudentController@show')
            ->name('schedules.students.show');

        Route::get('student-schedules/{student}/create', 'ScheduleStudentController@create')
            ->name('schedules.students.create');

        Route::post('student-schedules/{student}', 'ScheduleStudentController@store')
            ->name('schedules.students.store');

        Route::delete('student-schedules/{student}/credit/{scheduleDetail}', 'ScheduleStudentController@destroy')
            ->name('schedules.students.destroy');

        Route::post('student-schedules/{student}/status', 'ScheduleStudentController@creditStatus')
            ->name('schedules.students.creditStatus');

        Route::get('class-schedules', 'ScheduleClassController@index')
            ->name('schedules.classes.index');

        Route::get('class-schedules/{class}/credit', 'ScheduleClassController@show')
            ->name('schedules.classes.show');

        Route::delete('class-schedules/{class}/credit/{schedule}', 'ScheduleClassController@destroy')
            ->name('schedules.classes.destroy');

        Route::put('class-schedules/{schedule}', 'ScheduleClassController@update')
            ->name('schedules.classes.update');

        Route::get('class-schedules/{class}/create', 'ScheduleClassController@create')
            ->name('schedules.classes.create');

        Route::post('class-schedules/{class}', 'ScheduleClassController@store')
            ->name('schedules.classes.store');

        Route::resource('classes', 'ClassController')
            ->except('show');

        Route::get('classes/{class}/students', 'ClassController@studentsShow')
            ->name('classes.students');

        Route::post('classes/{class}/remove-student', 'ClassController@removeStudent')
            ->name('classes.remove_student');

        Route::post('grades/{grade}/credit-status', 'GradeController@registerCreditStatus')
            ->name('grades.creditStatus');

        Route::resource('students', 'StudentController')
            ->except('show');
    });

    Route::get('login', 'LoginController@showLoginForm')
        ->name('loginShow');

    Route::post('login', 'LoginController@login')
        ->name('login');

    Route::get('logout', 'LoginController@logout')
        ->name('logout');
});

Route::get('register_success/{route}', function ($route) {
    return redirect()->route($route)->with(['message' => 'Xử Lý Thành Công']);
})->name('redirect_route');
