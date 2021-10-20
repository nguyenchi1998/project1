<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\ISpecializationRepository;
use App\Repositories\ISubjectRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    private $subjectRepository;
    private $specializationRepository;

    public function __construct(
        ISubjectRepository        $subjectRepository,
        ISpecializationRepository $specializationRepository
    )
    {
        $this->subjectRepository = $subjectRepository;
        $this->specializationRepository = $specializationRepository;
    }

    public function index(Request $request)
    {
        $filter = $request->get('filter');
        $subjects = $this->subjectRepository->model()
            ->with(['specializations' => function ($query) use ($filter) {
                $query->when(!$filter || $filter == 'all', function ($query) {
                }, function ($query) use ($filter) {
                    $query->where('specializations.id', $filter);
                });
            }])->get();
        $subjects = $subjects->map(function ($subject) {
            $specializations = array_map(function ($specialization) {
                return $specialization['name'];
            }, $subject->specializations->toArray());
            $subject['specializations'] = implode(',', $specializations);

            return $subject;
        });
        $specializations = $this->specializationRepository->all();

        return view('admin.subject.index', compact('subjects', 'specializations', 'filter'));
    }

    public function create()
    {
        $specializations = $this->specializationRepository->all();
        $semesters = [];
        for ($i = 1; $i <= config('common.semester.max'); $i++) {
            $semesters[$i] = $i;
        }

        return view('admin.subject.create', compact('specializations', 'semesters'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $basic = $request->get('basic');
            $subject = $this->subjectRepository->create([
                'name' => $request->get('name'),
                'credit' => $request->get('credit'),
                'semester' => $request->get('semester'),
                'type' => $basic ? config('common.subject.type.basic') : config('common.subject.type.specialization'),
                'force' => $basic ? config('common.subject.force.basic') : 0,
            ]);
            if ($basic) {
                $specializations = $this->specializationRepository->get('id');
            } else {
                $specializations = $this->specializationRepository->whereIn('id', $request->get('specializations'))
                    ->get()
                    ->pluck('id');
            }
            $subject->specializations()->attach($specializations);
            DB::commit();

            return redirect()->route('admin.subjects.index');
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
        $subject = $this->subjectRepository->find($id);
        if ($subject) {
            $subject = $subject->load('specializations');
        }
        $subject['specializations'] = $subject->specializations->pluck('id')
            ->toArray();
        $specializations = $this->specializationRepository->all();

        return view('admin.subject.edit', compact('subject', 'specializations'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->subjectRepository->update($id, [
                'name' => $request->get('name'),
                'credit' => $request->get('credit'),
            ]);
            $subject = $this->subjectRepository->find($id);
            $subject->specializations()->sync($request->get('specializations'));
            DB::commit();

            return redirect()->route('admin.subjects.index');
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back();
        }

    }

    public function destroy($id)
    {
        //
    }
}
