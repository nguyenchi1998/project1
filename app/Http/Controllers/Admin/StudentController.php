<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\IClassRoomRepository;
use App\Repositories\IGradeRepository;
use App\Repositories\ISpecializationRepository;
use App\Repositories\IStudentRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    protected $studentRepository;
    protected $classRepository;
    protected $specializationRepository;
    protected $gradeRepository;
    protected $roleRepository;

    public function __construct(
        IStudentRepository        $studentRepository,
        IClassRoomRepository      $classRepository
    ) {
        $this->studentRepository = $studentRepository;
        $this->classRepository = $classRepository;
    }

    public function index(Request $request)
    {
        $keyword = $request->get('keyword');
        $students = $this->studentRepository->model()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('email', 'like', '%' . $keyword . '%')
                    ->orWhere('phone', $keyword);
            })
            ->with('classRoom')
            ->paginate(config('config.paginate'));
        $classes = $this->classRepository->all()->pluck('name', 'id');

        return view('admin.student.index', compact(
            'students',
            'keyword'
        ));
    }

    public function create()
    {
        $classRooms = $this->classRepository->all()->pluck('name', 'id')->toArray();

        return view('admin.student.create', compact('classRooms'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $student = $this->studentRepository
                ->create(array_merge($request->only([
                    'name',
                    'email',
                    'phone',
                    'birthday',
                    'address',
                    'gender',
                    'grade_id',
                ]), [
                    'password' => Hash::make(config('default.auth.password'))
                ]));
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
            DB::commit();

            return $this->successRouteRedirect('admin.students.index');
        } catch (Exception $e) {
            DB::rollBack();

            return $this->failRouteRedirect($e->getMessage());
        }
    }


    public function edit($id)
    { $classRooms = $this->classRepository->all()->pluck('name', 'id')->toArray();
        $student = $this->studentRepository->find($id);

        return view('admin.student.edit', compact('student', 'classRooms'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $student = $this->studentRepository->find($id)
                ->load('avatar');
            $student->update($request->only([
                'name',
                'phone',
                'birthday',
                'address',
                'gender',
                'grade_id',
            ]));
            if ($request->file('avatar')) {
                $imageDeleted = $this->studentRepository
                    ->deleteImage($student->avatar);
                if (!$imageDeleted) {
                    throw new Exception('Error delete old image');
                }
                $avatar = $request->file('avatar');
                $avatarFilename = $student->email . '.' . $avatar->getClientOriginalExtension();
                $path = $this->studentRepository->saveImage(
                    $avatar,
                    $avatarFilename,
                    config('default.avatar_size'),
                    config('default.avatar_size')
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
