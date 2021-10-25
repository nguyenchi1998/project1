<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\IClassRepository;
use App\Repositories\IGradeRepository;
use App\Repositories\IStudentRepository;
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
        $filterClass = $request->get('filter_class');
        $keyword = $request->get('keyword');
        $students = $this->studentRepository->model()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('phone', $keyword)
                    ->orWhere('email', 'like', '%' . $keyword . '%');
            })
            ->when($filterClass && $filterClass != 'all', function ($query) use ($filterClass) {
                $query->whereHas('class', function ($query) use ($filterClass) {
                    $query->whereId($filterClass);
                });
            })
            ->paginate(config('common.paginate'));
        $classes = $this->classRepository->all();

        return view('admin.student.index', compact('students', 'filterClass', 'classes', 'keyword'));
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
                config('common.roles.student.name'),
                config('common.roles.student.guard'));
            $student->assignRole($studentRole);
            DB::commit();

            return redirect()->route('admin.students.index');
        } catch (Exception $e) {
            DB::rollBack();

            return back()->withErrors(['msg' => $e->getMessage()]);
        }
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
        //
    }

    public function destroy($id)
    {
        $result = $this->studentRepository->delete($id);

        if ($result) {
            return redirect()->route('admin.students.index');
        }
        return redirect()->route('admin.students.index')->withErrors(['msg' => 'Delete Error']);
    }
}
