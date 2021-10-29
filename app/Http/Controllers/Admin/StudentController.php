<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\IClassRepository;
use App\Repositories\IGradeRepository;
use App\Repositories\IStudentRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    protected $studentRepository;
    protected $classRepository;
    protected $gradeRepository;

    public function __construct(
        IStudentRepository $studentRepository,
        IClassRepository   $classRepository,
        IGradeRepository   $gradeRepository
    ) {
        $this->studentRepository = $studentRepository;
        $this->classRepository = $classRepository;
        $this->gradeRepository = $gradeRepository;
    }

    public function index(Request $request)
    {
        $classFilter = $request->get('class-filter');
        $keyword = $request->get('keyword');
        $students = $this->studentRepository->model()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('phone', $keyword)
                    ->orWhere('email', 'like', '%' . $keyword . '%');
            })
            ->when($classFilter, function ($query) use ($classFilter) {
                $query->whereHas('class', function ($query) use ($classFilter) {
                    $query->whereId($classFilter);
                });
            })
            ->paginate(config('config.paginate'));
        $classes = $this->classRepository->all()->pluck('id')->toArray();

        return view('admin.student.index', compact('students', 'classFilter', 'classes', 'keyword'));
    }

    public function create()
    {
        $grades = $this->gradeRepository->all()->pluck('name', 'id')->toArray();

        return view('admin.student.create', compact('grades'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $student = $this->studentRepository->create(array_merge($request->only([
                'name', 'email', 'phone', 'birthday', 'address', 'gender', 'grade_id',
            ]), ['password' => Hash::make(config('default.auth.password'))]));
            $avatar = $request->file('avatar');
            $avatarFilename = $student->email . '.' . $avatar->getClientOriginalExtension();
            $path = $this->studentRepository->saveImage(
                $avatar,
                $avatarFilename,
                100,
                100
            );
            $student->avatar()->create([
                'path' => $path
            ]);
            $studentRole = $this->roleRepository->findByName(
                config('config.roles.student.name'),
                config('config.roles.student.guard')
            );
            $student->assignRole($studentRole);
            DB::commit();

            return $this->successRouteRedirect('admin.students.index');
        } catch (Exception $e) {
            DB::rollBack();

            return $this->failRouteRedirect();
        }
    }


    public function edit($id)
    {
        $student = $this->studentRepository->find($id);

        return view('admin.student.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $student = $this->studentRepository->find($id)
                ->load('avatar');
            $student->update($request->only([
                'name', 'email', 'phone', 'birthday', 'address', 'gender', 'grade_id',
            ]));
            if ($request->file('avatar')) {
                $imageDeleted = $this->studentRepository->deleteImage($student->avatar->path);
                if (!$imageDeleted) {
                    throw new Exception('Error delete old image');
                }
                $avatar = $request->file('avatar');
                $avatarFilename = $student->email . '.' . $avatar->getClientOriginalExtension();
                $path = $this->studentRepository->saveImage(
                    $avatar,
                    $avatarFilename,
                    100,
                    100
                );
                $student->avatar()->update([
                    'path' => $path
                ]);
            }
            DB::commit();

            return $this->successRouteRedirect('admin.students.index');
        } catch (Exception $e) {
            DB::rollBack();

            return $this->failRouteRedirect($e->getMessage());
        }
    }

    public function destroy($id)
    {
        $result = $this->studentRepository->delete($id);

        if ($result) {
            return $this->successRouteRedirect('admin.students.index');
        }

        return $this->failRouteRedirect();
    }

    public function restore($id)
    {
        $result = $this->studentRepository->restore($id);
        if ($result) {
            return $this->successRouteRedirect('admin.students.index');
        }

        return $this->failRouteRedirect();
    }
}
