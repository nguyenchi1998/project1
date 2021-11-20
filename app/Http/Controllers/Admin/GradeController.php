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
            ->with('students')
            ->paginate(config('config.paginate'));

        return view('admin.grade.index', compact('grades', 'keyword'));
    }

    public function create()
    {
        return view('admin.grade.create');
    }


    public function store(Request $request)
    {
        $this->gradeRepository->create($request->only(['name',]));

        return $this->successRouteRedirect('admin.grades.index');
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
            return $this->successRouteRedirect('admin.grades.index');
        }

        return $this->failRouteRedirect();
    }

    public function destroy($id)
    {
        $result = $this->gradeRepository->delete($id);

        if ($result) {
            return $this->successRouteRedirect('admin.grades.index');
        }
        return $this->failRouteRedirect();
    }

    public function restore($id)
    {
        $result = $this->gradeRepository->restore($id);
        if ($result) {
            return $this->successRouteRedirect('admin.grades.index');
        }

        return $this->failRouteRedirect();
    }

    public function registerCreditStatus(Request $request, $id)
    {
        $this->gradeRepository->update($id, $request->only('can_register_credit'));

        return $this->successRouteRedirect('admin.grades.index');
    }
}
