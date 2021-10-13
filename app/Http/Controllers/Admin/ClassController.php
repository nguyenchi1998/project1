<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateClass;
use App\Repositories\IClassRepository;
use App\Repositories\IStudentRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ClassController extends Controller
{
    protected $classRepository;
    protected $studentRepository;

    public function __construct(
        IClassRepository   $classRepository,
        IStudentRepository $studentRepository
    )
    {
        $this->classRepository = $classRepository;
        $this->studentRepository = $studentRepository;
    }

    public function index()
    {
        $classes = $this->classRepository->all()->load('students');

        return view('admin.class.index', compact('classes'));
    }

    public function create()
    {
        $students = $this->studentRepository->model()->has('class', '=', 0)->get();

        if (!count($students)) {
            return redirect()->route('classes.index')
                ->withErrors(['msg' => 'All student has class']);
        }

        return view('admin.class.create', compact('students'));
    }


    public function store(Request $request)
    {
        $students = $request->get('students');
        $name = $request->get('name');
        try {
            DB::beginTransaction();
            $class = $this->classRepository->create([
                'name' => $name
            ]);
            $this->studentRepository->whereIn('id', $students)->update([
                'class_id' => $class->id
            ]);
            DB::commit();

            return redirect()->route('students.index');
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors(['msg' => 'System Error, please try later']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $class = $this->classRepository->find($id);
        $studentsNotHasClass = $this->studentRepository->model()->has('class', '=', 0)->get();
        $students = $studentsNotHasClass->merge($class->students);

        return view('admin.class.edit', compact('class', 'students'));
    }


    public function update(UpdateClass $request, $id)
    {
        $students = $request->get('students');
        $name = $request->get('name');
        try {
            DB::beginTransaction();
            $this->classRepository->update($id, [
                'name' => $name
            ]);
            $this->studentRepository->whereIn('id', $students)->update([
                'class_id' => $id,
            ]);
            DB::commit();

            return redirect()->route('students.index');
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors(['msg' => 'System Error, please try later']);
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
