<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\TeacherCollection;
use App\Http\Resources\TeacherResource;
use App\Models\Teacher;
use App\Repositories\IDepartmentRepository;
use App\Repositories\ISubjectRepository;
use App\Repositories\ITeacherRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    protected $departmentRepository;
    protected $teacherRepository;
    protected $roleRepository;
    protected $subjectRepository;

    public function __construct(
        IDepartmentRepository $departmentRepository,
        ITeacherRepository $teacherRrpository,
        ISubjectRepository $subjectRepository
    ) {
        $this->departmentRepository = $departmentRepository;
        $this->teacherRepository = $teacherRrpository;
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
            ->with(['department', 'nextDepartment'])
            ->get();

        return new TeacherResource($teachers);
    }

    public function show($id)
    {
        $teacher = $this->teacherRepository->findOrFail($id);

        return new TeacherResource($teacher);
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
            DB::commit();

            return new Teacher($teacher);
        } catch (Exception $e) {
            DB::rollBack();

            return $this->failRouteRedirect();
        }
    }

    public function update(Request $request, $id)
    {
        $teacher = $this->teacherRepository->findOrFail($id)
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
                return redirect()->back()->withErrors([
                    'msg' => 'Teacher has department change, please contact to manager to handle'
                ]);
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
