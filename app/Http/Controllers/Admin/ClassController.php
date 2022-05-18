<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\IClassRoomRepository;
use App\Repositories\IStudentRepository;
use App\Repositories\ITeacherRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassController extends Controller
{
    protected $classRepository;
    protected $studentRepository;
    protected $teacherRepository;

    public function __construct(
        IClassRoomRepository $classRepository,
        ITeacherRepository   $teacherRepository,
        IStudentRepository   $studentRepository
    ) {
        $this->classRepository = $classRepository;
        $this->studentRepository = $studentRepository;
        $this->teacherRepository = $teacherRepository;
    }

    public function index(Request $request)
    {
        $keyword = $request->get('keyword');
        $classes = $this->classRepository->model()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->with(['students'])
            ->paginate(config('config.paginate'));

        return view('admin.class.index', compact(
            'classes',
            'keyword'
        ));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $students = $request->get('students');
            $class = $this->classRepository->create(
                array_merge($request->only(['name',]), [
                    'semester' => config('config.start_semester')
                ])
            );
            $this->studentRepository->whereIn('id', $students)
                ->update([
                    'class_room_id' => $class->id
                ]);
            DB::commit();

            return $this->successRouteRedirect('admin.classes.index');
        } catch (Exception $e) {
            DB::rollBack();

            return $this->failRouteRedirect($e->getMessage());
        }
    }

    public function create()
    {
        $students = $this->studentRepository->model()
            ->whereNull('class_room_id')
            ->get();
        $managerTeachers = $this->teacherRepository->all()
            ->pluck('name', 'id')->toArray();

        return view('admin.class.create', compact('students', 'managerTeachers'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->classRepository->update(
                $id,
                $request->only(['name'])
            );
            DB::commit();

            return $this->successRouteRedirect('admin.classes.index');
        } catch (Exception $e) {
            DB::rollBack();

            return $this->failRouteRedirect($e->getMessage());
        }
    }


    public function edit($id)
    {
        $class = $this->classRepository->find($id);
        $managerTeachers = $this->teacherRepository->all()
            ->pluck('name', 'id')->toArray();

        return view('admin.class.edit', compact(
            'class',
            'managerTeachers'
        ));
    }

    public function studentsShow($id)
    {
        $class = $this->classRepository->find($id)->load('students');

        return view('admin.class.show_students', compact(
            'class'
        ));
    }

    public function removeStudent(Request $request, $id)
    {
        $result = $this->studentRepository->update(
            $request->get('student_id'),
            [
                'class_room_id' => null,
            ]
        );
        if ($result) {
            return $this->successRouteRedirect(
                'admin.classes.students',
                [$id]
            );
        }

        return $this->failRouteRedirect();
    }

    public function destroy($id)
    {
        $result = $this->classRepository->delete($id);
        if ($result) {
            return $this->successRouteRedirect('admin.classes.index');
        }

        return $this->failRouteRedirect();
    }

    public function restore($id)
    {
        $result = $this->classRepository->restore($id);
        if ($result) {
            return $this->successRouteRedirect('admin.classes.index');
        }

        return $this->failRouteRedirect();
    }
}
