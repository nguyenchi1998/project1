<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateClass;
use App\Repositories\IClassRepository;
use App\Repositories\ISpecializationRepository;
use App\Repositories\IStudentRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ClassController extends Controller
{
    protected $classRepository;
    protected $studentRepository;
    protected $specializationRepository;

    public function __construct(
        IClassRepository          $classRepository,
        IStudentRepository        $studentRepository,
        ISpecializationRepository $specializationRepository
    ) {
        $this->classRepository = $classRepository;
        $this->studentRepository = $studentRepository;
        $this->specializationRepository = $specializationRepository;
    }

    public function index(Request $request)
    {
        $filterSpecialization = $request->get('filter_specializaiton');
        $keyword = $request->get('keyword');
        $specializations = $this->specializationRepository->all();
        $classes = $this->classRepository->model()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('phone', $keyword)
                    ->orWhere('email', 'like', '%' . $keyword . '%');
            })
            ->when($filterSpecialization && $filterSpecialization != 'all', function ($query) use ($filterSpecialization) {
                $query->whereHas('specialization', function ($query) use ($filterSpecialization) {
                    $query->whereId($filterSpecialization);
                });
            })->with('students')
            ->paginate(config('common.paginate'));

        return view('admin.class.index', compact('classes', 'filterSpecialization', 'keyword', 'specializations'));
    }

    public function create()
    {
        $students = $this->studentRepository->model()
            ->has('class', '=', 0)
            ->get();
        if (!count($students)) {
            return redirect()->route('admin.classes.index')
                ->withErrors(['msg' => 'All student has class']);
        }

        return view('admin.class.create', compact('students'));
    }


    public function store(Request $request)
    {
        $students = $request->get('students');
        try {
            DB::beginTransaction();
            $class = $this->classRepository->create(
                $request->only(['name', 'specialization_id'])
            );
            $this->studentRepository->whereIn('id', $students)->update([
                'class_id' => $class->id
            ]);
            DB::commit();

            return redirect()->route('admin.classes.index');
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors([
                'msg' => 'System Error, please try later'
            ]);
        }
    }

    public function show($id)
    {
        $class = $this->classRepository->find($id);
        if ($class) {
            $class->load('students');
        }

        return view('admin.class.show', compact('class'));
    }

    public function edit($id)
    {
        $class = $this->classRepository->find($id);
        $studentsNotHasClass = $this->studentRepository->model()
            ->has('class', '=', 0)
            ->get();
        $students = $studentsNotHasClass->merge($class->students);

        return view('admin.class.edit', compact('class', 'students'));
    }


    public function update(UpdateClass $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->classRepository->update($id, $request->only(['name']));
            DB::commit();

            return redirect()->route('admin.classes.index');
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withErrors([
                    'msg' => 'System Error, please try later'
                ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
