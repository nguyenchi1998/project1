<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\IDepartmentRepository;
use App\Repositories\IUserRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequestController extends Controller
{
    protected $departmentRepository;
    protected $userRepository;

    public function __construct(IDepartmentRepository $departmentRepository, IUserRepository $userRepository)
    {
        $this->departmentRepository = $departmentRepository;
        $this->userRepository = $userRepository;
    }

    public function index()
    {

        $titleRequest = [
            'change' => 'Change Department',
            'upgrade' => 'Upgrade to Manager',
            'downgrade' => 'Downgrade to Member',
        ];
        $moveDepartmenteTeachers = $this->userRepository->where('next_department_id', null, '!=')->get();
        if ($moveDepartmenteTeachers) {
            $moveDepartmenteTeachers->load(['department', 'nextDepartment']);
        }
        $moveDepartmenteTeachers = $moveDepartmenteTeachers->map(function ($teacher) use ($titleRequest) {
            $teacher['seniority'] = Carbon::now()->diffInYears($teacher->created_at);
            $title = [];
            if ($teacher->nextDepartment->next_manager_id == $teacher->id) {
                $title[] = $titleRequest['upgrade'];
            }
            if ($teacher->next_department_id == $teacher->department_id
                && $teacher->department->manager_id == $teacher->id) {
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
        $teacher = $this->userRepository->find($teacherId);
        if ($teacher) {
            $teacher->load('department', 'nextDepartment');
        }
        try {
            DB::beginTransaction();
            if ($teacher->department->manager_id == $teacher->id) {
                if ($teacher->department_id == $teacher->next_department_id) {
                    $this->departmentRepository->update($teacher->department_id, [
                        'manager_id' => null,
                        'next_manager_id' => null,
                    ]);
                } else {
                    $department = $this->departmentRepository->find($teacher->next_department_id);
                    $department->update([
                        'manager_id' => $teacher->id,
                        'next_manager_id' => null,
                    ]);
                }
            } else {
                $department = $this->departmentRepository->find($teacher->next_department_id);
                $department->update([
                    'manager_id' => $department->next_manager_id,
                    'next_manager_id' => null,
                ]);
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
}
