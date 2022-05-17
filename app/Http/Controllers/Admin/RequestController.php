<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\ITeacherRepository;

class RequestController extends Controller
{
    protected $departmentRepository;
    protected $teacherRepository;

    public function __construct(
        ITeacherRepository $teacherRepository
    ) {
        $this->teacherRepository = $teacherRepository;
    }

    public function index()
    {

        return view('admin.request.index', compact());
    }
}
