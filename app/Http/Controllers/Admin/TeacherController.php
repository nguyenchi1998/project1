<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\IDepartmentRepository;
use App\Repositories\IUserRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    private $departmentRepository;
    private $userRepository;

    public function __construct(IDepartmentRepository $departmentRepository, IUserRepository $userRepository)
    {
        $this->departmentRepository = $departmentRepository;
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        $filter = $request->get('filter');
        $teachers = $this->userRepository->model()->wherehas('roles', function ($query) {
            $query->where('name', 'teacher');
        })->get()->load(['roles:id,name', 'department', 'nextDepartment']);
        $departments = $this->departmentRepository->all();

        return view('admin.teacher.index', compact('teachers', 'filter', 'departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $teacher = $this->userRepository->find($id);
        if ($teacher) {
            $teacher->load('department');
        }
        $departments = $this->departmentRepository->all();

        return view('admin.teacher.edit', compact('teacher', 'departments'));
    }

    public function update(Request $request, $id)
    {
        $this->userRepository->update($id, $request->only(['name', 'gender', 'birthday', 'address', 'phone']));

        return redirect()->route('admin.teachers.index');
    }

    public function changeDepartmentShow($id)
    {
        $teacher = $this->userRepository->find($id)->load('department');
        $departments = $this->departmentRepository->all();

        return view('admin.teacher.change_department', compact('teacher', 'departments'));
    }

    public function changeDepartment(Request $request, $id)
    {
        $departmentId = $request->get('department_id');
        $isManager = $request->get('isManager');
        try {
            DB::beginTransaction();
            $teacher = $this->userRepository->find($id)->load('department');
            if ($teacher->next_department_id) {
                return redirect()->back()->withErrors(['msg' => 'Teacher has department change, please contact to manager to handle']);
            }
            if ($isManager ) {
                $this->departmentRepository->update($departmentId, [
                    'next_manager_id' => $teacher->id,
                    'next_manager_status' => config('status.department.next_manager.pending')
                ]);
            }
            $this->userRepository->update($id, [
                'next_department_id' => $departmentId,
            ]);
            DB::commit();

            return redirect()->route('admin.teachers.index');
        } catch (Exception $e) {
            DB::rollBack();

            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
