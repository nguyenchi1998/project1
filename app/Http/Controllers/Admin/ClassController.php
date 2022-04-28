<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateClassRequest;
use App\Http\Resources\ClassCollection;
use App\Http\Resources\ClassResource;
use App\Http\Resources\ClassRoom;
use App\Repositories\IClassRoomRepository;
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
        IClassRoomRepository          $classRepository,
        IStudentRepository        $studentRepository,
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
        $classes = $this->classRepository->withTrashedModel()
            ->inprogressClass()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->when($filterSpecialization, function ($query) use ($filterSpecialization) {
                $query->whereHas('specialization', function ($query) use ($filterSpecialization) {
                    $query->where('id', $filterSpecialization);
                });
            })
            ->with(['students', 'specialization'])
            ->get();

        return ClassResource::collection($classes);
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
                    'class_room_id' => $class->id
                ]);
            DB::commit();

            return new ClassResource($class);
        } catch (Exception $e) {
            DB::rollBack();

            return $this->errorResponse($e->getMessage());
        }
    }

    public function show($id)
    {
        $class = $this->classRepository->findOrFail($id);

        return new ClassResource($class);
    }

    public function update(UpdateClassRequest $request, $id)
    {
        $result = $this->classRepository->update($id, $request->only(['name']));
        if ($result) {
            return $this->successResponse();
        }

        return $this->errorResponse();
    }

    public function removeStudent(Request $request, $id)
    {
        $result = $this->studentRepository->update(
            $request->get('student_id'),
            [
                'class_room_id' => null,
            ]
        );
        if ($result) {
            return $this->successResponse();
        }

        return $this->errorResponse();
    }

    public function destroy($id)
    {
        $result = $this->classRepository->delete($id);
        if ($result) {
            return $this->successResponse();
        }

        return $this->errorResponse();
    }

    public function restore($id)
    {
        $result = $this->classRepository->restore($id);
        if ($result) {
            return $this->successResponse();
        }

        return $this->errorResponse();
    }

    public function nextSemester()
    {
        try {
            DB::beginTransaction();
            $this->classRepository->model()->inprogressClass()
                ->whereRaw('semester >= ?', [config('config.max_semester')])
                ->update([
                    'finish' => true,
                ]);
            $this->classRepository->model()->inprogressClass()
                ->whereRaw('semester < ?', [config('config.max_semester')])
                ->update([
                    'semester' => DB::raw('semester + 1'),
                ]);
            DB::commit();
            return $this->successResponse();
        } catch (Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage());
        }
    }
}
