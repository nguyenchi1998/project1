<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\IGradeRepository;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    protected $gradeRepository;

    public function __construct(IGradeRepository $gradeRepository)
    {
        $this->gradeRepository = $gradeRepository;
    }

    public function index(Request $request)
    {
        $keyword = $request->get('keyword');
        $grades = $this->gradeRepository->model()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->paginate(config('config.paginate'))->load('students');

        return view('admin.grade.index', compact('grades', 'keyword'));
    }

    public function create()
    {
        return view('admin.grade.create');
    }


    public function store(Request $request)
    {
        $this->gradeRepository->create($request->only(['name',]));

        return redirect()->route('admin.grade.index');
    }


    public function edit($id)
    {
        $grade = $this->gradeRepository->find($id);

        return view('admin.grade.edit', compact('grade'));
    }

    public function update(Request $request, $id)
    {
        $success = $this->gradeRepository->update(
            $id,
            $request->only(['name',])
        );
        if ($success) {
            return redirect()->route('admin.grade.index');
        }

        return redirect()->back();
    }

    public function destroy($id)
    {
        $result = $this->gradeRepository->delete($id);

        if ($result) {
            return redirect()->route('admin.grades.index');
        }
        return redirect()->route('admin.grades.index')->withErrors(['msg' => 'Delete Error']);
    }
}
