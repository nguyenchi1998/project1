<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\ITeacherRepository;

class HomeController extends Controller
{
    protected $teacherRepository;

    public function __construct(
        ITeacherRepository $teacherRepository
    )
    {
        $this->teacherRepository = $teacherRepository;
    }

    public function index()
    {
        return view('admin.dashboard');
    }
}
