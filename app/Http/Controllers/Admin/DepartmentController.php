<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\IDepartmentRepository;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    protected $departmentRepository;

    public function __construct(IDepartmentRepository $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    public function index(Request $request)
    {
        $keyword = $request->get('keyword');
        $departments = $this->departmentRepository->where('name', 'like', '%' . $keyword . '%')
            ->with('teachers')
            ->paginate(config('config.paginate'));

        return view('admin.department.index', compact('departments', 'keyword'));
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
        $result = $this->departmentRepository->delete($id);

        if ($result) {
            return redirect()->route('admin.departmants.index');
        }
        return redirect()->route('admin.departments.index')->withErrors(['msg' => 'Delete Error']);
    }
}
