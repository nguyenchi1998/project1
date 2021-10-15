<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\IDepartmentRepository;
use App\Repositories\IRoleRepository;
use App\Repositories\IUserRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use ImageResize;

class TeacherController extends Controller
{
    private $departmentRepository;
    private $userRepository;
    private $roleRepository;

    public function __construct(IDepartmentRepository $departmentRepository, IUserRepository $userRepository, IRoleRepository $roleRepository)
    {
        $this->departmentRepository = $departmentRepository;
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    public function index(Request $request)
    {
        $filter = $request->get('filter');
        $teachers = $this->userRepository->model()
            ->when($filter && $filter != 'all', function ($query) use ($filter) {
                $query->whereHas('department', function ($query) use ($filter) {
                    $query->whereId($filter);
                });
            })
            ->wherehas('roles', function ($query) {
                $query->whereName('teacher');
            })
            ->get()
            ->load(['roles:id,name', 'department', 'nextDepartment']);
        $departments = $this->departmentRepository->all();

        return view('admin.teacher.index', compact('teachers', 'filter', 'departments'));
    }

    public function create()
    {
        $departments = $this->departmentRepository->all();

        return view('admin.teacher.create', compact('departments'));
    }


    public function store(Request $request)
    {
//        try {
        DB::beginTransaction();
        $teacher = $this->userRepository->create(array_merge($request->only([
            'name', 'email', 'phone', 'birthday', 'address', 'gender', 'department_id',
        ]), ['password' => Hash::make(config('default.auth.password'))]));
        $avatar = $request->file('avatar');
        $avatarFilename = $teacher->email . '.' . $request->file('avatar')->getClientOriginalExtension();
        $path = $this->userRepository->saveImage(
            $avatar,
            $avatarFilename,
            storage_path(config('default.path.media.avatar.teacher')),
            100,
            10
        );
           dd($path);
           $teacher->avatar()->create([
               'path' => storage_path() . $avatarFilename
           ]);


            $teacherRole = $this->roleRepository->findByName(config('common.roles.teacher.name'));
            $teacher->assignRole($teacherRole);
            DB::commit();

            return redirect()->route('admin.teachers.index');
//        } catch (Exception $e) {
//            DB::rollBack();
//
//            return back();
//        }
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
            if ($isManager) {
                $this->departmentRepository->update($departmentId, [
                    'next_manager_id' => $teacher->id,
                    'next_manager_status' => config('status.department.next_manager.pending')
                ]);
            }
            if()
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
