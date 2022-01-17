<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Grade;
use App\Http\Resources\GradeCollection;
use App\Http\Resources\GradeResource;
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
            ->get();

        return GradeResource::collection($grades);
    }

    public function store(Request $request)
    {
        $grade = $this->gradeRepository->create($request->only(['name',]));

        return new GradeResource($grade);
    }

    public function update(Request $request, $id)
    {
        $success = $this->gradeRepository->update(
            $id,
            $request->only(['name',])
        );
        if ($success) {
            return $this->successRouteRedirect();
        }

        return $this->failRouteRedirect();
    }

    public function destroy($id)
    {
        $grade = $this->gradeRepository->find($id)->load('students');
        $result = $this->gradeRepository->delete($id, !count($grade->students));
        if ($result) {
            return $this->successRouteRedirect();
        }

        return $this->failRouteRedirect();
    }

    public function restore($id)
    {
        $result = $this->gradeRepository->restore($id);
        if ($result) {
            return $this->successRouteRedirect();
        }

        return $this->failRouteRedirect();
    }

    public function registerCreditStatus(Request $request, $id)
    {
        $result = $this->gradeRepository->update(
            $id,
            $request->only('can_register_credit')
        );
        if ($result) {
            return $this->successRouteRedirect();
        }

        return $this->failRouteRedirect();
    }
}
