<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\IClassRepository;
use App\Repositories\IGradeRepository;
use App\Repositories\IStudentRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StudentController extends Controller
{
    protected $studentRepository;
    protected $classRepository;
    protected $gradeRepository;

    public function __construct(
        IStudentRepository $studentRepository,
        IClassRepository $classRepository,
        IGradeRepository $gradeRepository
    )
    {
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
                    $query->whereId( $filterClass);
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
