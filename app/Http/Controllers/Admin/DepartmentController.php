<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\IDepartmentRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DepartmentController extends Controller
{
    protected $departmentRepository;

    public function __construct(IDepartmentRepository $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }


    public function index()
    {
        $departments = $this->departmentRepository->all()->load('teachers');

        return view('admin.department.index', compact('departments'));
    }

    public function create()
    {
        return view('admin.department.create');
    }

    public function store(Request $request)
    {
        $this->departmentRepository->create($request->only('name'));

        return redirect()->route('admin.departments.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $department = $this->departmentRepository->find($id);

        return view('admin.department.edit', compact('department'));
    }

    public function update(Request $request, $id)
    {
        $this->departmentRepository->update($id, $request->only('name'));

        return redirect()->route('admin.departments.index');
    }

    public function destroy($id)
    {
        //
    }
}
