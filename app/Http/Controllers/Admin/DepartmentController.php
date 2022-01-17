<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Department;
use App\Http\Resources\DepartmentResource;
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
            ->with(['teachers', 'manager'])
            ->get();

        return  DepartmentResource::collection($departments);
    }

    public function store(Request $request)
    {
        $department = $this->departmentRepository->create($request->only('name'));

        return new DepartmentResource($department);
    }

    public function update(Request $request, $id)
    {
        $result = $this->departmentRepository->update($id, $request->only('name'));

        if ($result) {
            return $this->successRouteRedirect();
        }

        return $this->failRouteRedirect();
    }

    public function destroy($id)
    {
        $result = $this->departmentRepository->delete($id);
        if ($result) {
            return $this->successRouteRedirect();
        }

        return $this->failRouteRedirect();
    }

    public function restore($id)
    {
        $result = $this->departmentRepository->restore($id);
        if ($result) {
            return $this->successRouteRedirect();
        }

        return $this->failRouteRedirect();
    }

    public function changeManager(Request $request, $departmentId)
    {
        $result = $this->departmentRepository->update($departmentId, [
            'next_manager_id' => $request->get('next_manager_id'),
            'next_manager_status' => config('status.department.next_manager.pending')
        ]);

        if ($result) {
            return $this->successRouteRedirect();
        }

        return $this->failRouteRedirect();
    }
}
