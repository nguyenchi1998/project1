<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\IDepartmentRepository;
use App\Repositories\ITeacherRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequestController extends Controller
{
    protected $departmentRepository;
    protected $teacherRepository;

    public function __construct(
        IDepartmentRepository $departmentRepository,
        ITeacherRepository $teacherRepository
    ) {
        $this->departmentRepository = $departmentRepository;
        $this->teacherRepository = $teacherRepository;
    }

    public function index()
    {
        $changeDepartmentTeacherRequest = $this->teacherRepository->model()
            ->whereNotNull('next_department_id')
            ->get();
        $changeDepartmentManagerRequest = $this->departmentRepository->model()
            ->whereNotNull('next_manager_id')
            ->get();

        return view('admin.request.index', compact(
            'changeDepartmentTeacherRequest',
            'changeDepartmentManagerRequest'
        ));
    }

    public function departmentTeacher(Request $request, $teacherId)
    {
        $status = $request->get('status');
        $this->teacherRepository->update($teacherId, [
            'department_id' => $status ? $request->get('next_department_id') : null,
            'next_department_id' => null,
            'next_department_status' => config('status.department.next_manager.success'),
        ]);

        return $this->successRouteRedirect('admin.requests.index');
    }

    public function departmentManager(Request $request, $departmentId)
    {
        $status = $request->get('status');
        $this->departmentRepository->update($departmentId, [
            'manager_id' => $status ? $request->get('next_manager_id') : null,
            'next_manager_id' => null,
            'next_manager_status' => config('status.teacher.next_department.success'),
        ]);

        return $this->successRouteRedirect('admin.requests.index');
    }
}
