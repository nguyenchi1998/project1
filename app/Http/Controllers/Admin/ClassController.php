<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateClass;
use App\Repositories\IClassRepository;
use App\Repositories\ISpecializationRepository;
use App\Repositories\IStudentRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassController extends Controller
{
    protected $classRepository;
    protected $studentRepository;
    protected $specializationRepository;

    public function __construct(
        IClassRepository          $classRepository,
        IStudentRepository        $studentRepository,
        ISpecializationRepository $specializationRepository
    )
    {
        $this->classRepository = $classRepository;
        $this->studentRepository = $studentRepository;
        $this->specializationRepository = $specializationRepository;
    }

    public function index(Request $request)
    {
        $filterSpecialization = $request->get('specializaiton-filter');
        $keyword = $request->get('keyword');
        $specializations = $this->specializationRepository->all()->pluck('name', 'id')->toArray();
        $classes = $this->classRepository->withTrashedModel()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->when($filterSpecialization, function ($query) use ($filterSpecialization) {
                $query->whereHas('specialization', function ($query) use ($filterSpecialization) {
                    $query->where('id', $filterSpecialization);
                });
            })
            ->with(['students', 'specialization'])
            ->paginate(config('config.paginate'));

        return view('admin.class.index', compact('classes', 'filterSpecialization', 'keyword', 'specializations'));
    }

    public function create()
    {
        $students = $this->studentRepository->model()
            ->has('class', '=', 0)
            ->get();
        if (!count($students)) {
            return $this->failRouteRedirect('All student has class');
        }

        return view('admin.class.create', compact('students'));
    }

    public function store(Request $request)
    {
        $students = $request->get('students');
        try {
            DB::beginTransaction();
            $class = $this->classRepository->create(
                $request->only(['name', 'specialization_id'])
            );
            $this->studentRepository->whereIn('id', $students)->update([
                'class_id' => $class->id
            ]);
            DB::commit();

            return $this->successRouteRedirect('admin.classes.index');
        } catch (Exception $e) {
            DB::rollBack();

            return $this->failRouteRedirect();
        }
    }

    public function show($id)
    {
        $class = $this->classRepository->find($id);
        if ($class) {
            $class->load('students');
        }

        return view('admin.class.show', compact('class'));
    }

    public function edit($id)
    {
        $class = $this->classRepository->find($id);
        $studentsNotHasClass = $this->studentRepository->model()
            ->has('class', '=', 0)
            ->get();
        $students = $studentsNotHasClass->merge($class->students);

        return view('admin.class.edit', compact('class', 'students'));
    }


    public function update(UpdateClass $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->classRepository->update($id, $request->only(['name']));
            DB::commit();

            return $this->successRouteRedirect('admin.classes.index');
        } catch (Exception $e) {
            DB::rollBack();

            return $this->failRouteRedirect();
        }
    }

    public function nextSemester()
    {
        try {
            DB::beginTransaction();
            $resultClass = $this->classRepository->model()
                ->whereHas('specialization', function ($query) {
                    $query->where('total_semester', '>', DB::raw('classes.semester'));
                })->update([
                    'semester' => DB::raw('classes.semester + 1'),
                ]);
            $resultStudent = $this->studentRepository->model()
                ->query()
                ->update([
                    'can_register_credit' => config('config.can_register_credit'),
                ]);
            if ($resultClass && $resultStudent) {
                DB::commit();

                return $this->successRouteRedirect('admin.classes.index');
            }
            throw new Exception();
        } catch (Exception $e) {
            DB::rollBack();

            return $this->failRouteRedirect();
        }
    }

    public function removeStudent(Request $request)
    {
        $rs = $this->studentRepository->update($request->get('student_id'), [
            'class_id' => null,
        ]);
        if ($rs) {
            return back()->with('msg', 'Xóa sinh viên thành công');
        }
        return back()->withErrors(['msg' => 'Xóa sinh viên thất bại']);
    }

    public function destroy($id)
    {
        $result = $this->classRepository->delete($id);

        if ($result) {
            return $this->successRouteRedirect('admin.classes.index');
        }
        return $this->failRouteRedirect();;
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
