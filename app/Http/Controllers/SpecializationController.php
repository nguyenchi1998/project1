<?php

namespace App\Http\Controllers;

use App\Repositories\ISpecializationRepository;
use App\Repositories\ISubjectRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpecializationController extends Controller
{
    protected $specializationRepository;
    protected $subjectRepository;

    public function __construct(ISpecializationRepository $specializationRepository, ISubjectRepository $subjectRepository)
    {
        $this->specializationRepository = $specializationRepository;
        $this->subjectRepository = $subjectRepository;
    }

    public function index()
    {
        $specializations = $this->specializationRepository->all()->load('subjects');

        return view('manager.specialization.index', compact('specializations'));
    }


    public function create()
    {
        $subjects = $this->subjectRepository->where('type', null)->get();

        return view('manager.specialization.create', compact('subjects'));
    }


    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $specialization = $this->specializationRepository->create([
                'name' => $request->get('name'),
            ]);
            $basicSubjects = $this->subjectRepository->where('type', config('common.subjectType.basic'))->get()
                ->pluck('id')->toArray();
            $subjects = $request->get('subjects');
            $specialization->subjects()->attach(array_merge($basicSubjects, $subjects));
            DB::commit();

            return redirect()->route('specializations.index');
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

        return view('manager.specialization.edit', compact('specialization', 'subjects'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $specialization = $this->specializationRepository->update($id, [
                'name' => $request->get('name'),
            ]);
            $basicSubjects = $this->subjectRepository->where('type', null)->get()->pluck('id')->toArray();
            $subjects = $request->get('subjects');
            $specialization->subjects()->sync(array_merge($basicSubjects, $subjects));
            DB::commit();

            return redirect()->route('specializations.index');
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
