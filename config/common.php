<?php

return [
    'role' => [
        'admin' => 'admin',
    ],
    'guard' => [
        'admin' => 'admin',
        'teacher' => 'teacher',
        'student' => 'student',
    ],
    'subject' => [
        'type' => [
            'basic' => 0,
            'specialization' => 1,
        ],
        'force' => 1,
        'unforce' => 0,
    ],
    'status' => [
        'schedule' => [
            'new' => 0,
            'inprogess' => 1,
            'finish' => 2,
            'marking' => 3,
            'done' => 4,
        ],
        'scheduleDetail' => [
            'relearn' => 0,
            'retest' => 1,
            'pass' => 2,
        ],
    ],
    'can_register_credit' => 1,
    'semester' => [
        'default' => 1,
        'max' => 6,
    ],
    'limit' => [
        'studentInClass' => 20,
    ],
    'roles' => [
        'superAdmin' => [
            'name' => 'super-admin',
            'guard' => 'admin',
        ],
        'admin' => [
            'name' => 'admin',
            'guard' => 'admin',
            'permissions' => [
                "listSubject" => "list-subject",
                "showSubject" => "show-subject",
                "updateSubject" => "update-subject",
                "createSubject" => "create-subject",
                "deleteSubject" => "delete-subject",
                "listMark" => "list-mark",
                "showMark" => "show-mark",
                "updateMark" => "update-mark",
                "createMark" => "create-mark",
                "deleteMark" => "delete-mark",
                "listStudent" => "list-student",
                "showStudent" => "show-student",
                "updateStudent" => "update-student",
                "createStudent" => "create-student",
                "deleteStudent" => "delete-student",
                "listAdmin" => "list-admin",
                "showAdmin" => "show-admin",
                "updateAdmin" => "update-admin",
                "createAdmin" => "create-admin",
                "deleteAdmin" => "delete-admin",
                "listSchedule" => "list-schedule",
                "showSchedule" => "show-schedule",
                "updateSchedule" => "update-schedule",
                "createSchedule" => "create-schedule",
                "deleteSchedule" => "delete-schedule",
            ],
        ],
        'teacher' => [
            'name' => 'teacher',
            'guard' => 'teacher',
        ],
        'student' => [
            'name' => 'student',
            'guard' => 'student',
        ],
    ],
];
