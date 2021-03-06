<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubjectCollection;
use App\Http\Resources\SubjectResource;
use App\Repositories\IDepartmentRepository;
use App\Repositories\ISpecializationRepository;
use App\Repositories\ISubjectRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    protected $subjectRepository;
    protected $departmentRepository;
    protected $specializationRepository;

    public function __construct(
        ISubjectRepository $subjectRepository,
        ISpecializationRepository $specializationRepository,
        IDepartmentRepository $departmentRepository
    ) {
        $this->subjectRepository = $subjectRepository;
        $this->departmentRepository = $departmentRepository;
        $this->specializationRepository = $specializationRepository;
    }

    public function index(Request $request)
    {
        $departmentFilter = $request->get('department-filter');
        $typeFilter = $request->get('type-filter');
        $keyword = $request->get('keyword');
        $subjects = $this->subjectRepository->withTrashedModel()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->when($typeFilter != null, function ($query) use ($typeFilter) {
                $query->where('type', $typeFilter);
            })
            ->when($departmentFilter, function ($query) use ($departmentFilter) {
                $query->whereHas('department', function ($query) use ($departmentFilter) {
                    $query->where('id', $departmentFilter);
                });
            })
            ->with('department')
            ->get();

        return SubjectResource::collection($subjects);
    }

    public function show($id)
    {
        $subject = $this->subjectRepository->findOrFail($id);

        return new SubjectResource($subject);
    }

    public function store(Request $request)
    {
        $subject = $this->subjectRepository->create(
            $request->only([
                'name',
                'credit',
                'type',
                'department_id',
            ])
        );

        return new SubjectResource($subject);
    }

    public function update(Request $request, $id)
    {
        $result = $this->subjectRepository->update(
            $id,
            $request->only(['name', 'credit', 'semester'])
        );
        if ($result) {
            return $this->successResponse();
        }

        return $this->errorResponse();
    }

    public function destroy($id)
    {
        $result = $this->subjectRepository->delete($id);
        if ($result) {
            return $this->successResponse();
        }

        return $this->errorResponse();
    }

    public function restore($id)
    {
        $result = $this->subjectRepository->restore($id);
        if ($result) {
            return $this->successResponse();
        }

        return $this->errorResponse();
    }
}
