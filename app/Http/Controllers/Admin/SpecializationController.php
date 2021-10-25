<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        $specializations = $this->specializationRepository->model()
            ->with(['subjects', 'department'])
            ->paginate(config('config.paginate'));

        return view('admin.specialization.index', compact('specializations', 'keyword'));
    }


    public function create()
    {
        $departments = $this->departmentRepository->all()->pluck('name', 'id');

        return view('admin.specialization.create', compact('departments'));
    }


    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $this->specializationRepository->create($request->only([
                'name',
                'min_credit',
                'total_semester',
                'department_id',
            ]));

            DB::commit();

            return redirect()->route('admin.specializations.index');
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors(['msg' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $specialization = $this->specializationRepository->find($id);
        if ($specialization) {
            $specialization = $specialization->load('subjects');
        }
        $specialization['subjects'] = $specialization->subjects->pluck('id')->toArray();
        $subjects = $this->subjectRepository->all();

        return view('admin.specialization.edit', compact('specialization', 'subjects'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->specializationRepository->update($id, $request->only(['name', 'min_credit', 'total_semester']));
            $specialization = $this->specializationRepository->find($id);
            $basicSubjects = $this->subjectRepository->where('type', '=', null)->get()->pluck('id')->toArray();
            $specialization->subjects()->sync(array_merge($basicSubjects, $request->get('subjects')));
            DB::commit();

            return redirect()->route('admin.specializations.index');
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors('Error');
        }
    }

    public function destroy($id)
    {
        $result = $this->specializationRepository->delete($id);

        if ($result) {
            return redirect()->route('admin.specializations.index');
        }
        return redirect()->route('admin.specializations.index')->withErrors(['msg' => 'Delete Error']);
    }

    public function chooseSubjectShow($id)
    {

        $specialization = $this->specializationRepository->find($id)->load('subjects');
        $subjectForce = $specialization->subjects;
        $subjects = $this->subjectRepository->where('type', '=', config('config.subject.type.specialization'))
            ->get();

        return view('admin.specialization.choose_subject', compact('specialization', 'subjects', 'subjectForce'));
    }

    public function chooseSubject(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $subjectIds = $request->get('subjects');
            $specialization = $this->specializationRepository->find($id);
            $specialization->subjects()->sync($subjectIds);
            DB::commit();

            return redirect()->route('admin.specializations.index');
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors([
                'msg' => $e->getMessage(),
            ]);
        }
    }
}
