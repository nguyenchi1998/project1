<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentCollection;
use App\Http\Resources\StudentResource;
use App\Repositories\IClassRepository;
use App\Repositories\IGradeRepository;
use App\Repositories\ISpecializationRepository;
use App\Repositories\IStudentRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    protected $studentRepository;
    protected $classRepository;
    protected $specializationRepository;
    protected $gradeRepository;
    protected $roleRepository;

    public function __construct(
        IStudentRepository $studentRepository,
        IClassRepository $classRepository,
        IGradeRepository $gradeRepository,
        ISpecializationRepository $specializationRepository
    ) {
        $this->studentRepository = $studentRepository;
        $this->classRepository = $classRepository;
        $this->gradeRepository = $gradeRepository;
        $this->specializationRepository = $specializationRepository;
    }

    public function index(Request $request)
    {
        $specializationFilter = $request->get('specialization-filter');
        $keyword = $request->get('keyword');
        $students = $this->studentRepository->model()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('email', 'like', '%' . $keyword . '%')
                    ->orWhere('phone', $keyword);
            })
            ->when($specializationFilter, function ($query) use ($specializationFilter) {
                $query->whereHas('class.specialization', function ($query) use ($specializationFilter) {
                    $query->whereId($specializationFilter);
                });
            })
            ->with('class.specialization')
            ->get();

        return  StudentResource::collection($students);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $student = $this->studentRepository->create(
                array_merge(
                    $request->only([
                        'name', 'email', 'phone', 'birthday', 'address', 'gender', 'grade_id',
                    ]),
                    ['password' => Hash::make(config('default.auth.password'))]
                )
            );
            $avatar = $request->file('avatar');
            if ($avatar) {
                $avatarFilename = $student->email . '.' . $avatar->getClientOriginalExtension();
                $path = $this->studentRepository->saveImage(
                    $avatar,
                    $avatarFilename,
                    100,
                    100
                );
                $student->avatar()->create([
                    'path' => $path
                ]);
            }
            DB::commit();

            return new StudentResource($student);
        } catch (Exception $e) {
            DB::rollBack();

            return $this->failRouteRedirect($e->getMessage());
        }
    }

    public function show($id)
    {
        $student = $this->studentRepository->findOrFail($id);

        return new StudentResource($student);
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $student = $this->studentRepository->findOrFail($id)
                ->load('avatar');
            $student->update($request->only([
                'name', 'phone', 'birthday', 'address', 'gender', 'grade_id',
            ]));
            if ($request->file('avatar')) {
                $imageDeleted = $this->studentRepository->deleteImage($student->avatar->path);
                if (!$imageDeleted) {
                    throw new Exception('Error delete old image');
                }
                $avatar = $request->file('avatar');
                $avatarFilename = $student->email . '.' . $avatar->getClientOriginalExtension();
                $path = $this->studentRepository->saveImage(
                    $avatar,
                    $avatarFilename,
                    config('default.avatar_size'),
                    config('default.avatar_size')
                );
                $student->avatar()->update([
                    'path' => $path
                ]);
            }
            DB::commit();

            return $this->successRouteRedirect();
        } catch (Exception $e) {
            DB::rollBack();

            return $this->failRouteRedirect($e->getMessage());
        }
    }

    public function destroy($id)
    {
        $result = $this->studentRepository->delete($id);
        if ($result) {
            return $this->successRouteRedirect();
        }

        return $this->failRouteRedirect();
    }

    public function restore($id)
    {
        $result = $this->studentRepository->restore($id);
        if ($result) {
            return $this->successRouteRedirect();
        }

        return $this->failRouteRedirect();
    }
}
