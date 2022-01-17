<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChooseSubjectRequest;
use App\Http\Resources\SpecializationCollection;
use App\Http\Resources\SpecializationResource;
use App\Repositories\IDepartmentRepository;
use App\Repositories\ISpecializationRepository;
use App\Repositories\ISubjectRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpecializationController extends Controller
{
    protected $specializationRepository;
    protected $subjectRepository;
    protected $departmentRepository;

    public function __construct(
        ISpecializationRepository $specializationRepository,
        IDepartmentRepository     $departmentRepository,
        ISubjectRepository        $subjectRepository
    ) {
        $this->specializationRepository = $specializationRepository;
        $this->subjectRepository = $subjectRepository;
        $this->departmentRepository = $departmentRepository;
    }

    public function index(Request $request)
    {
        $keyword = $request->get('keyword');
        $departmentFilter = $request->get('department-filter');
        $specializations = $this->specializationRepository->withTrashedModel()
            ->when($departmentFilter, function ($query) use ($departmentFilter) {
                $query->whereHas('department', function ($query) use ($departmentFilter) {
                    $query->where('id', $departmentFilter);
                });
            })
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name', $keyword);
            })
            ->with(['subjects', 'department'])
            ->get();

        return SpecializationResource::collection($specializations);
    }

    public function show($id)
    {
        $specialization = $this->specializationRepository->findOrFail($id);

        return new SpecializationResource($specialization);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $specialization = $this->specializationRepository->create($request->only([
                'name',
                'min_credit',
                'department_id',
            ]));
            $basicSubjectIds = $this->subjectRepository->model()
                ->basicSubjects()
                ->get()
                ->reduce(function ($subjects, $subject) {
                    $subjects[$subject->id] = [
                        'semester' => $subject->semester,
                        'force' => config('subject.force'),
                    ];

                    return $subjects;
                }, []);
            $specialization->subjects()->sync($basicSubjectIds);
            DB::commit();

            return new SpecializationCollection($specialization);
        } catch (Exception $e) {
            DB::rollBack();

            return $this->failRouteRedirect($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->specializationRepository->update($id, $request->only([
                'name',
                'min_credit',
            ]));
            DB::commit();

            return $this->successRouteRedirect();
        } catch (Exception $e) {
            DB::rollBack();

            return $this->failRouteRedirect($e->getMessage());
        }
    }

    public function destroy($id)
    {
        $result = $this->specializationRepository->delete($id);

        if ($result) {
            return $this->successRouteRedirect();
        }
        return $this->failRouteRedirect();
    }


    public function restore($id)
    {
        $result = $this->specializationRepository->restore($id);
        if ($result) {
            return $this->successRouteRedirect();
        }

        return $this->failRouteRedirect();
    }

    public function chooseSubjectShow($id)
    {
        $subjects = $this->subjectRepository->allWithTrashed();
        $specialization = $this->specializationRepository->find($id)
            ->load('subjects');
        $specializationSubjects = $specialization->subjects->pluck('id')
            ->toArray();

        return view('admin.specialization.choose_subject', compact(
            'specialization',
            'specializationSubjects',
            'subjects'
        ));
    }

    public function chooseSubject(ChooseSubjectRequest $request, $id)
    {
        $specialization = $this->specializationRepository->find($id);
        $specialization->subjects()
            ->sync($request->get('subjectIds'));

        return $this->successRouteRedirect('admin.specializations.choose_subject_show', $id);
    }
}
