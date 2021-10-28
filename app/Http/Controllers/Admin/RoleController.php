<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\IPermissionRepository;
use App\Repositories\IRoleRepository;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $roleRepository;
    protected $permissionRepository;

    public function __construct(
        IRoleRepository       $roleRepository,
        IPermissionRepository $permissionRepository
    )
    {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    public function index()
    {
        $roles = $this->roleRepository->whereNotIn(['super-admin'])
            ->get()
            ->load('permissions');

        return view('admin.role.index', compact('roles'));
    }

    public function edit($id)
    {
        $role = $this->roleRepository->findById($id)
            ->load('permissions');
        $permissions = $this->permissionRepository->where('guard_name', $role->guard_name)->get();

        return view('admin.role.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        $this->roleRepository->assignPermissions($id, $request->get('permissions'));

        return redirect()->route('admin.roles.index');
    }
}
