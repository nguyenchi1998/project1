<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\ISubjectRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    protected $subjectRepository;

    public function __construct(
        ISubjectRepository $subjectRepository
    )
    {
        $this->subjectRepository = $subjectRepository;
    }

    public function index(Request $request)
    {
        $typeFilter = $request->get('type-filter');
        $keyword = $request->get('keyword');
        $subjects = $this->subjectRepository->model()
            ->when(
                $keyword,
                function ($query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%');
                }
            )
            ->when(
                $typeFilter != null,
                function ($query) use ($typeFilter) {
                    $query->where('type', $typeFilter);
                }
            )
            ->paginate(config('config.paginate'));

        return view('admin.subject.index', compact(
            'subjects',
            'typeFilter',
            'keyword'
        ));
    }

    public function store(Request $request)
    {
        $this->subjectRepository->create(
            $request->only([
                'name',
                'credit',
                'type',
                'department_id',
            ])
        );

        return $this->successRouteRedirect('admin.subjects.index');
    }

    public function create()
    {
        return view('admin.subject.create');
    }

    public function edit($id)
    {
        $subject = $this->subjectRepository->find($id);

        return view('admin.subject.edit', compact(
            'subject'
        ));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        $subject = $this->subjectRepository
            ->find($id);
        $subject->update($request->only([
            'name',
            'credit',
            'semester'
        ]));
        DB::commit();

        return $this->successRouteRedirect('admin.subjects.index');
    }

    public function destroy($id)
    {
        $result = $this->subjectRepository
            ->delete($id);
        if ($result) {
            return $this->successRouteRedirect('admin.subjects.index');
        }

        return $this->failRouteRedirect();
    }

    public function restore($id)
    {
        $result = $this->subjectRepository->restore($id);
        if ($result) {
            return $this->successRouteRedirect('admin.subjects.index');
        }

        return $this->failRouteRedirect();
    }
}
