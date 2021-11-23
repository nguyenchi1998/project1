<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\IDepartmentRepository;
use App\Repositories\IRoleRepository;
use App\Repositories\ISubjectRepository;
use App\Repositories\ITeacherRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use ImageResize;

class TeacherController extends Controller
{
    protected $departmentRepository;
    protected $teacherRepository;
    protected $roleRepository;
    protected $subjectRepository;

    public function __construct(
        IDepartmentRepository $departmentRepository,
        ITeacherRepository    $teacherRrpository,
        IRoleRepository       $roleRepository,
        ISubjectRepository    $subjectRepository
    ) {
        $this->departmentRepository = $departmentRepository;
        $this->teacherRepository = $teacherRrpository;
        $this->roleRepository = $roleRepository;
        $this->subjectRepository = $subjectRepository;
    }

    public function index(Request $request)
    {
        $keyword = $request->get('keyword');
        $departmentFilter = $request->get('department-filter');
        $teachers = $this->teacherRepository->model()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('email', 'like', '%' . $keyword . '%')
                    ->orWhere('phone', $keyword);
            })
            ->when($departmentFilter, function ($query) use ($departmentFilter) {
                $query->whereHas('department', function ($query) use ($departmentFilter) {
                    $query->whereId($departmentFilter);
                });
            })
            ->with(['roles:id,name', 'department', 'nextDepartment'])
            ->paginate(config('config.paginate'));
        $departments = $this->departmentRepository->all()->pluck('name', 'id');

        return view('admin.teacher.index', compact('teachers', 'departmentFilter', 'departments', 'keyword'));
    }

    public function create()
    {
        $departments = $this->departmentRepository->all();

        return view('admin.teacher.create', compact('departments'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $teacher = $this->teacherRepository->create(array_merge($request->only([
                'name', 'email', 'phone', 'birthday', 'address', 'gender', 'department_id',
            ]), ['password' => Hash::make(config('default.auth.password'))]));
            $avatar = $request->file('avatar');
            $avatarFilename = $teacher->email . '.' . $avatar->getClientOriginalExtension();
            $path = $this->teacherRepository->saveImage(
                $avatar,
                $avatarFilename,
                config('default.avatar_size'),
                config('default.avatar_size')
            );
            $teacher->avatar()->create([
                'path' => $path
            ]);
            $teacherRole = $this->roleRepository->findByName(
                config('role.roles.teacher.name'),
                config('role.roles.teacher.guard')
            );
            $teacher->assignRole($teacherRole);
            DB::commit();

            return redirect()->route('admin.teachers.index');
        } catch (Exception $e) {
            DB::rollBack();

            return back()->withErrors(['msg' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $teacher = $this->teacherRepository->find($id);
        if ($teacher) {
            $teacher->load('department');
        }
        $departments = $this->departmentRepository->all();

        return view('admin.teacher.edit', compact('teacher', 'departments'));
    }

    public function update(Request $request, $id)
    {
        $teacher = $this->teacherRepository->find($id)
            ->load('avatar');
        $teacher->update($id, $request->only(['name', 'gender', 'birthday', 'address', 'phone']));

        if ($request->file('avatar')) {
            $imageDeleted = $this->teacherRepository->deleteImage($teacher->avatar->path);
            if (!$imageDeleted) {
                throw new Exception('Error delete old image');
            }
            $avatar = $request->file('avatar');
            $avatarFilename = $teacher->email . '.' . $avatar->getClientOriginalExtension();
            $path = $this->studentRepository->saveImage(
                $avatar,
                $avatarFilename,
                config('default.avatar_size'),
                config('default.avatar_size')
            );
            $teacher->avatar()->update([
                'path' => $path
            ]);
        }

        return redirect()->route('admin.teachers.index');
    }

    public function changeDepartmentShow($id)
    {
        $teacher = $this->teacherRepository->find($id)->load('department');
        $departments = $this->departmentRepository->all();

        return view('admin.teacher.change_department', compact('teacher', 'departments'));
    }

    public function changeDepartment(Request $request, $id)
    {
        $departmentId = $request->get('department_id');
        $isManager = $request->get('isManager');
        try {
            DB::beginTransaction();
            $teacher = $this->teacherRepository->find($id)->load('department');
            if ($teacher->next_department_id) {
                return redirect()->back()->withErrors(['msg' => 'Teacher has department change, please contact to manager to handle']);
            }
            if ($isManager) {
                $this->departmentRepository->update($departmentId, [
                    'next_manager_id' => $teacher->id,
                    'next_manager_status' => config('status.department.next_manager.pending')
                ]);
            }
            if ($teacher->department_id != $departmentId) {
                $this->teacherRepository->update($id, [
                    'next_department_id' => $departmentId,
                ]);
            }
            DB::commit();

            return redirect()->route('admin.teachers.index');
        } catch (Exception $e) {
            DB::rollBack();

            return back();
        }
    }

    public function chooseSubjectShow($id)
    {
        $teacher = $this->teacherRepository->find($id)
            ->load(['subjects' => function ($query) {
                $query->orderBy('name');
            }, 'department']);
        $teacherSubjects = $teacher->subjects->pluck('id')
            ->toArray();
        $subjects = $teacher->department->subjects;

        return view('admin.teacher.choose_subject', compact('teacher', 'subjects', 'teacherSubjects'));
    }

    public function chooseSubject(Request $request, $id)
    {
        $subjectIds = $request->get('subject_id');
        $teacher = $this->teacherRepository->find($id);
        $teacher->subjects()->sync($subjectIds);

        return redirect()->route('admin.teachers.index');
    }

    public function destroy($id)
    {
        $result = $this->teacherRepository->delete($id);

        if ($result) {
            return redirect()->route('admin.teachers.index');
        }
        return redirect()->route('admin.teachers.index')
            ->withErrors(['msg' => 'Delete Error']);
    }

    public function restore($id)
    {
        $result = $this->teacherRepository->restore($id);
        if ($result) {
            return $this->successRouteRedirect('admin.teachers.index');
        }

        return $this->failRouteRedirect();
    }
}
