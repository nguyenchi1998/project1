<?php

return [
    'guard' => [
        'admin' => 'admin',
        'teacher' => 'teacher',
        'student' => 'student',
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
            'display_name' => 'Giáo Viên'
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
