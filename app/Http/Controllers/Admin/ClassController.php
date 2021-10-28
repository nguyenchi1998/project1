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
        $filterSpecialization = $request->get('filter_specializaiton');
        $keyword = $request->get('keyword');
        $specializations = $this->specializationRepository->all();
        $classes = $this->classRepository->model()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('phone', $keyword)
                    ->orWhere('email', 'like', '%' . $keyword . '%');
            })
            ->when($filterSpecialization && $filterSpecialization != 'all', function ($query) use ($filterSpecialization) {
                $query->whereHas('specialization', function ($query) use ($filterSpecialization) {
                    $query->whereId($filterSpecialization);
                });
            })->with('students')
            ->paginate(config('config.paginate'));

        return view('admin.class.index', compact('classes', 'filterSpecialization', 'keyword', 'specializations'));
    }

    public function create()
    {
        $students = $this->studentRepository->model()
            ->has('class', '=', 0)
            ->get();
        if (!count($students)) {
            return redirect()->route('admin.classes.index')
                ->withErrors(['msg' => 'All student has class']);
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

            return redirect()->route('admin.classes.index');
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors([
                'msg' => 'System Error, please try later'
            ]);
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

            return redirect()->route('admin.classes.index');
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withErrors([
                    'msg' => 'System Error, please try later'
                ]);
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

                return redirect()->route('admin.classes.index')
                    ->with('success', 'Chuyển kỳ và mở đăng kí tín chỉ cho sinh viên thành công');
            }
            throw new Exception();
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->route('admin.classes.index')
                ->withErrors(['msg' => 'Chuyển kỳ và mở đăng kí tín chỉ cho sinh viên thất bại']);
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
            return redirect()->route('admin.classes.index')->with('msg', 'Xóa Lớp Thành Công');
        }
        return redirect()->route('admin.classes.index')->withErrors(['msg' => 'Xóa Lớp Thất Bại']);
    }
}
