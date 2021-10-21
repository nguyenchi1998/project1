<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\IDepartmentRepository;
use App\Repositories\ITeacherRepository;

class HomeController extends Controller
{
    protected $departmentRepository;
    protected $teacherRepository;

    public function __construct(IDepartmentRepository $departmentRepository, ITeacherRepository $teacherRepository)
    {
        $this->departmentRepository = $departmentRepository;
        $this->teacherRepository = $teacherRepository;
    }

    public function index()
    {
        $moveDepartmenteTeachers = $this->teacherRepository->where('next_department_id', '!=', null)
            ->get();
        if ($moveDepartmenteTeachers) {
            $moveDepartmenteTeachers->load(['department', 'nextDepartment']);
        }

        return view('admin.dashboard', compact('moveDepartmenteTeachers'));
    }
}
