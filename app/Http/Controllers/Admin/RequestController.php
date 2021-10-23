<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\IDepartmentRepository;
use App\Repositories\ITeacherRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequestController extends Controller
{
    protected $departmentRepository;
    protected $teacherRepository;

    public function __construct(
        IDepartmentRepository $departmentRepository,
        ITeacherRepository $teacherRepository
    ) {
        $this->departmentRepository = $departmentRepository;
        $this->teacherRepository = $teacherRepository;
    }

    public function index()
    {
        $titleRequest = [
            'change' => 'Change Department',
            'upgrade' => 'Upgrade to Manager',
            'downgrade' => 'Downgrade to Member',
        ];
        $moveDepartmenteTeachers = $this->teacherRepository->where('next_department_id', '!=', null)->get();
        if ($moveDepartmenteTeachers) {
            $moveDepartmenteTeachers->load(['department', 'nextDepartment']);
        }
        $moveDepartmenteTeachers = $moveDepartmenteTeachers->map(function ($teacher) use ($titleRequest) {
            $teacher['seniority'] = Carbon::now()->diffInYears($teacher->created_at);
            $title = [];
            if ($teacher->nextDepartment->next_manager_id == $teacher->id) {
                $title[] = $titleRequest['upgrade'];
            }
            if (
                ($teacher->next_department_id == $teacher->department_id
                    && $teacher->department->manager_id == $teacher->id) ||
                ($teacher->next_department_id != $teacher->department_id
                    && $teacher->nextDepartment->next_manager_id != $teacher->id)
            ) {
                $title[] = $titleRequest['downgrade'];
            }
            if ($teacher->department_id != $teacher->next_department_id) {
                $title[] = $titleRequest['change'];
            }
            $teacher['titleRequest'] = implode(', ', $title);

            return $teacher;
        });

        return view('admin.request.index', compact('moveDepartmenteTeachers'));
    }

    public function approveDepartmentChange(Request $request)
    {
        $teacherId = $request->get('teacherId');
        $teacher = $this->teacherRepository->find($teacherId);
        if ($teacher) {
            $teacher->load('department', 'nextDepartment');
        }
        try {
            DB::beginTransaction();
            // same department
            if ($teacher->department_id == $teacher->next_department_id) {
                // upgrade to manager
                if ($teacher->department->next_manager_id == $teacher->id) {
                    $this->departmentRepository->update($teacher->department_id, [
                        'manager_id' => $teacher->id,
                        'next_manager_id' => null,
                    ]);
                } else {
                    $this->departmentRepository->update($teacher->department_id, [
                        'manager_id' => null,
                        'next_manager_id' => null,
                    ]);
                }
            } else {
                // remove departmnet manager
                if ($teacher->department->manager_id == $teacher->id) {
                    $this->departmentRepository->update($teacher->department_id, [
                        'manager_id' => null,
                        'next_manager_id' => null,
                    ]);
                }
                // upgrade new department manager
                if ($teacher->nextDepartment->next_manager_id == $teacher->id) {
                    $this->departmentRepository->update($teacher->next_department_id, [
                        'manager_id' => $teacher->id,
                        'next_manager_id' => null,
                    ]);
                }
            }
            $teacher->update([
                'department_id' => $teacher->next_department_id,
                'next_department_id' => null,
            ]);
            DB::commit();

            return redirect()->route('admin.requests.show');
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back();
        }
    }

    public function rejectDepartmentChange(Request $request)
    {
        $teacherId = $request->get('teacherId');
        $teacher = $this->teacherRepository->find($teacherId)->load(['department', 'nextDepartment']);
        if ($teacher->nextDepartment->next_manager_id == $teacher->id) {
            $this->departmentRepository->update($teacher->nextDepartment->id, [
                'next_manager_id' => null,
            ]);
        }
        $teacher->update([
            'next_department_id' => null
        ]);
    }
}
