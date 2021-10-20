<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\IDepartmentRepository;
use App\Repositories\IUserRepository;

class HomeController extends Controller
{
    protected $departmentRepository;
    protected $userRepository;

    public function __construct(IDepartmentRepository $departmentRepository, IUserRepository $userRepository)
    {
        $this->departmentRepository = $departmentRepository;
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $moveDepartmenteTeachers = $this->userRepository->where('next_department_id', '!=', null)->get();
        if ($moveDepartmenteTeachers) {
            $moveDepartmenteTeachers->load(['department', 'nextDepartment']);
        }

        return view('admin.dashboard', compact('moveDepartmenteTeachers'));
    }
}
