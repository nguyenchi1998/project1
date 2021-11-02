<?php

return [
    'gender' => [
        'male' => [
            'value' => 0,
            'name' => 'Nam'
        ],
        'female' => [
            'value' => 1,
            'name' => 'Nữ'
        ],
    ],
    'format_date_show' => 'd/m/Y',
    'max_semester_register_by_class' => 4,
    'max_semester' => 16,
    'paginate' => 8,
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
            'inprogress' => 1,
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
    'can_not_register_credit' => 0,
    'semester' => [
        'default' => 1,
        'max' => 6,
    ],
    'start_semester' => 1,
    'max_credit_register' => 20,
    'limit' => [
        'studentInClass' => 20,
    ],
    'roles' => [
        'super_admin' => [
            'name' => 'super-admin',
            'guard' => 'admin',
            'display_name' => 'Giám Đốc'
        ],
        'admin' => [
            'name' => 'admin',
            'guard' => 'admin',
            'display_name' => 'Quản Trị Viên'

        ],
        'teacher' => [
            'name' => 'teacher',
            'guard' => 'teacher',
            'display_name' => 'Giáo Vien'
        ],
        'student' => [
            'name' => 'student',
            'guard' => 'student',
            'display_name' => 'Sinh Viên'
        ],
    ],
    'permissions' => [
        'listSubject' => [
            'name' => 'list-subject',
            'display_name' => 'Xem Danh Sách Môn Học'
        ],
        'showSubject' => [
            'name' => 'show-subject',
            'display_name' => 'Xem Chi Tiết Hôm Học'
        ],
        'updateSubject' => [
            'name' => 'update-subject',
            'display_name' => 'Sửa Đổi Hôm Học'
        ],
        'createSubject' => [
            'name' => 'create-subject',
            'display_name' => 'Tạo Hôm Học'
        ],
        'deleteSubject' => [
            'name' => 'delete-subject',
            'display_name' => 'Xóa Hôm Học'
        ],
        'listMark' => [
            'name' => 'list-mark',
            'display_name' => 'Xem Danh Sách Điểm'
        ],
        'showMark' => [
            'name' => 'show-mark',
            'display_name' => 'Xem Chi Tiết Điểm'
        ],
        'updateMark' => [
            'name' => 'update-mark',
            'display_name' => 'Sửa Điểm'
        ],
        'createMark' => [
            'name' => 'create-mark',
            'display_name' => 'Tạo Điểm'
        ],
        'deleteMark' => [
            'name' => 'delete-mark',
            'display_name' => 'Xóa Điểm'
        ],
        'listStudent' => [
            'name' => 'list-student',
            'display_name' => 'Xem Danh Sách Sinh Viên'
        ],
        'showStudent' => [
            'name' => 'show-student',
            'display_name' => 'Xem Chi Tiết Sinh Viên'
        ],
        'updateStudent' => [
            'name' => 'update-student',
            'display_name' => 'Sửa Sinh Viên'
        ],
        'createStudent' => [
            'name' => 'create-student',
            'display_name' => 'Tạo Sinh Viên'
        ],
        'deleteStudent' => [
            'name' => 'delete-student',
            'display_name' => 'Xóa Sinh Viên'
        ],
        'listAdmin' => [
            'name' => 'list-admin',
            'display_name' => 'Xem Danh Sách Quản Trị Viên'
        ],
        'showAdmin' => [
            'name' => 'show-admin',
            'display_name' => 'Xem Chi Tiết Quản Trị Viên'
        ],
        'updateAdmin' => [
            'name' => 'update-admin',
            'display_name' => 'Sửa Quản Trị Viên'
        ],
        'createAdmin' => [
            'name' => 'create-admin',
            'display_name' => 'Tạo Quản Trị Viên'
        ],
        'deleteAdmin' => [
            'name' => 'delete-admin',
            'display_name' => 'Xóa Quản Trị Viên'
        ],
        'listSchedule' => [
            'name' => 'list-schedule',
            'display_name' => 'Xem Danh Sách Tín Chỉ'
        ],
        'showSchedule' => [
            'name' => 'show-schedule',
            'display_name' => 'Xem Chi Tiết Tín Chỉ'
        ],
        'updateSchedule' => [
            'name' => 'update-schedule',
            'display_name' => 'Sửa Tín Chỉ'
        ],
        'createSchedule' => [
            'name' => 'create-schedule',
            'display_name' => 'Tạo Tín Chỉ'
        ],
        'deleteSchedule' => [
            'name' => 'delete-schedule',
            'display_name' => 'Xóa Tín Chỉ'
        ],
    ]
];
