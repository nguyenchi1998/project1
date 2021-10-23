<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\ISpecializationRepository;
use App\Repositories\ISubjectRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpecializationController extends Controller
{
    protected $specializationRepository;
    protected $subjectRepository;

    public function __construct(
        ISpecializationRepository $specializationRepository,
        ISubjectRepository        $subjectRepository
    )
    {
        $this->specializationRepository = $specializationRepository;
        $this->subjectRepository = $subjectRepository;
    }

    public function index(Request $request)
    {
        $keyword = $request->get('keyword');
        $specializations = $this->specializationRepository->model()
            ->with(['subjects', 'department'])
            ->paginate(config('common.paginate'));

        return view('admin.specialization.index', compact('specializations', 'keyword'));
    }


    public function create()
    {
        $subjects = $this->subjectRepository->where('type', '=', null)
            ->get();

        return view('admin.specialization.create', compact('subjects'));
    }


    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $specialization = $this->specializationRepository->create($request->only(['name', 'min_credit', 'total_semester']));
            $basicSubjects = $this->subjectRepository->where('type', '=', config('common.subject.type.basic'))
                ->get()
                ->pluck('id')
                ->toArray();
            $subjects = $request->get('subjects');
            $specialization->subjects()->attach(array_merge($basicSubjects, $subjects));
            DB::commit();

            return redirect()->route('admin.specializations.index');
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors('Error');
        }
    }

    public function show($id)
    {
        //
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
        //
    }
}
