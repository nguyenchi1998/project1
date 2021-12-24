<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateClass;
use App\Repositories\IClassRepository;
use App\Repositories\ISpecializationRepository;
use App\Repositories\IStudentRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassController extends Controller
{
    protected $classRepository;
    protected $studentRepository;
    protected $specializationRepository;

    public function __construct(
        IClassRepository $classRepository,
        IStudentRepository $studentRepository,
        ISpecializationRepository $specializationRepository
    ) {
        $this->classRepository = $classRepository;
        $this->studentRepository = $studentRepository;
        $this->specializationRepository = $specializationRepository;
    }

    public function index(Request $request)
    {
        $filterSpecialization = $request->get('specializaiton-filter');
        $keyword = $request->get('keyword');
        $specializations = $this->specializationRepository->all()
            ->pluck('name', 'id')
            ->toArray();
        $showCreateClassBtn = $this->studentRepository->model()
            ->whereNull('class_id')
            ->get()
            ->count();
        $classes = $this->classRepository->withTrashedModel()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->when($filterSpecialization, function ($query) use ($filterSpecialization) {
                $query->whereHas('specialization', function ($query) use ($filterSpecialization) {
                    $query->where('id', $filterSpecialization);
                });
            })
            ->with(['students', 'specialization'])
            ->paginate(config('config.paginate'));

        return view('admin.class.index', compact(
            'classes',
            'filterSpecialization',
            'keyword',
            'specializations',
            'showCreateClassBtn'
        ));
    }

    public function create()
    {
        $students = $this->studentRepository->model()
            ->whereNull('class_id')
            ->get();

        return view('admin.class.create', compact('students'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $students = $request->get('students');
            $class = $this->classRepository->create(
                array_merge($request->only(['name', 'specialization_id']), [
                    'semester' => config('config.start_semester')
                ])
            );
            $this->studentRepository->whereIn('id', $students)
                ->update([
                    'class_id' => $class->id
                ]);
            DB::commit();

            return $this->successRouteRedirect('admin.classes.index');
        } catch (Exception $e) {
            DB::rollBack();

            return $this->failRouteRedirect($e->getMessage());
        }
    }

    public function studentsShow($id)
    {
        $studentsNotHasClass = $this->studentRepository->model()
            ->whereNull('class_id')
            ->get()
            ->count();
        $class = $this->classRepository->find($id)->load('students');

        return view('admin.class.show_students', compact('class', 'studentsNotHasClass'));
    }

    public function edit($id)
    {
        $class = $this->classRepository->find($id);

        return view('admin.class.edit', compact('class', 'students'));
    }


    public function update(UpdateClass $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->classRepository->update($id, $request->only(['name']));
            DB::commit();

            return $this->successRouteRedirect('admin.classes.index');
        } catch (Exception $e) {
            DB::rollBack();

            return $this->failRouteRedirect($e->getMessage());
        }
    }

    public function removeStudent(Request $request, $id)
    {
        $result = $this->studentRepository->update(
            $request->get('student_id'),
            [
                'class_id' => null,
            ]
        );
        if ($result) {
            return $this->successRouteRedirect('admin.classes.students', [$id]);
        }

        return $this->failRouteRedirect();
    }

    public function destroy($id)
    {
        $result = $this->classRepository->delete($id);
        if ($result) {
            return $this->successRouteRedirect('admin.classes.index');
        }

        return $this->failRouteRedirect();
    }

    public function restore($id)
    {
        $result = $this->classRepository->restore(
            $id,
        );
        if ($result) {
            return $this->successRouteRedirect('admin.classes.index');
        }

        return $this->failRouteRedirect();
    }
}
