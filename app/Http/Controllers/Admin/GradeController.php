<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\IGradeRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GradeController extends Controller
{
    protected $gradeRepository;

    public function __construct(IGradeRepository $gradeRepository)
    {
        $this->gradeRepository = $gradeRepository;
    }

    public function index()
    {
        $grades = $this->gradeRepository->all()->load('classes.students');

        $grades = $grades->map(function ($grade) {
            $students = array_reduce($grade->classes->toArray(), function ($sum, $class) {
                $sum += count($class['students']);

                return $sum;
            }, 0);
            $grade['students'] = $students;

            return $grade;
        });

        return view('admin.grade.index', compact('grades'));
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

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $grade = $this->gradeRepository->find($id);

        return view('admin.grade.edit', compact('grade'));
    }

    public function update(Request $request, $id)
    {
        $success = $this->gradeRepository->update($id, $request->only(['name',]));
        if ($success) {
            return redirect()->route('admin.grade.index');
        }
        return back();
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
