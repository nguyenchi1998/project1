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

        Route::post('teachers/{id}/choose-subject', 'TeacherController@chooseSubject')
            ->name('teachers.choose_subject');

        Route::resource('schedules', 'ScheduleController')
            ->only(['index', 'create', 'destroy', 'edit', 'update']);

        Route::post('schedules/{id}/teacher', 'ScheduleController@setTeacher')
            ->name('schedules.teacher');

        Route::post('schedules/{id}/status', 'ScheduleController@statusSchedule')
            ->name('schedules.status');

        Route::post('schedules/store', 'ScheduleController@store')
            ->name('schedules.register');

        // Route::get('schedules/{id}/choose-time', 'ScheduleController@scheduleTimeShow')
        //     ->name('schedules.scheduleTimeShow');

        // Route::post('schedules/{id}/choose-time', 'ScheduleController@scheduleTime')
        //     ->name('schedules.scheduleTime');

        Route::get('schedules/students', 'ScheduleStudentController@index')
            ->name('schedules.students.index');

        Route::get('schedules/students/{id}/credit', 'ScheduleStudentController@show')
            ->name('schedules.students.show');

        Route::get('schedules/students/{id}/create', 'ScheduleStudentController@create')
            ->name('schedules.students.create');

        Route::post('schedules/students/{id}', 'ScheduleStudentController@store')
            ->name('schedules.students.store');

        Route::delete('schedules/students/{studentId}/credit/{scheduleDetailId}', 'ScheduleStudentController@destroy')
            ->name('schedules.students.destroy');

        Route::post('schedules/students/{id}/status', 'ScheduleStudentController@creditStatus')
            ->name('schedules.students.creditStatus');

        Route::get('schedules/class', 'ScheduleClassController@index')
            ->name('schedules.classes.index');

        Route::get('schedules/class/{id}/credit', 'ScheduleClassController@show')
            ->name('schedules.classes.show');

        Route::delete('schedules/class/{classId}/credit/{scheduleId}', 'ScheduleClassController@destroy')
            ->name('schedules.classes.destroy');

        Route::get('schedules/class/{id}/create', 'ScheduleClassController@create')
            ->name('schedules.classes.create');

        Route::post('schedules/class/{id}', 'ScheduleClassController@store')
            ->name('schedules.classes.store');

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

        Route::post('departments/{id}/change-manager', 'DepartmentController@changeManager')
            ->name('departments.changeManager');

        Route::resource('students', 'StudentController')
            ->except('show');

        Route::group(['prefix' => 'requests', 'as' => 'requests.'], function () {
            Route::get('', 'RequestController@index')
                ->name('index');

            Route::post('/departmentManager/{departmentId}', 'RequestController@departmentManager')
                ->name('departmentManager');

            Route::post('/departmentTeacher/{teacherId}', 'RequestController@departmentTeacher')
                ->name('departmentTeacher');
        });
    });

    Route::get('login', 'LoginController@showLoginForm')
        ->name('loginShow');

    Route::post('login', 'LoginController@login')
        ->name('login');

    Route::get('logout', 'LoginController@logout')
        ->name('logout');

    Route::get('register_success/{route}', function ($route) {
        return redirect()->route($route)->with(['message' => 'Xử Lý Thành Công']);
    })->name('redirect_route');
});
