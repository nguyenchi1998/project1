<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\IManagerRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ManagerController extends Controller
{
    protected $managerRepository;

    public function __construct(
        IManagerRepository $managerRepository
    ) {
        $this->managerRepository = $managerRepository;
    }

    public function index(Request $request)
    {
        $keyword = $request->get('keyword');
        $managers = $this->managerRepository->model()
            ->isAdmin()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('phone', $keyword)
                    ->orWhere('email', 'like', '%' . $keyword . '%');
            })
            ->paginate(config('config.paginate'));

        return view('admin.manager.index', compact('managers', 'keyword'));
    }

    public function create()
    {
        return view('admin.manager.create');
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $manager = $this->managerRepository->create(array_merge($request->only([
                'name', 'email', 'phone', 'birthday', 'address', 'gender'
            ]), ['password' => Hash::make(config('default.auth.password'))]));
            $avatar = $request->file('avatar');
            $avatarFilename = $manager->email . '.' . $avatar->getClientOriginalExtension();
            $path = $this->managerRepository->saveImage(
                $avatar,
                $avatarFilename,
                config('default.avatar_size'),
                config('default.avatar_size')
            );
            $manager->avatar()->create([
                'path' => $path
            ]);
            $adminRole = $this->roleRepository->findByName(
                config('role.roles.admin.name'),
                config('role.roles.admin.guard')
            );
            $manager->assignRole($adminRole);
            DB::commit();

            return $this->successRouteRedirect('admin.managers.index');
        } catch (Exception $e) {
            DB::rollBack();

            return $this->failRouteRedirect($e->getMessage());
        }
    }

    public function edit($id)
    {
        $manager = $this->managerRepository->find($id);

        return view('admin.manager.edit', compact('manager'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $manager = $this->managerRepository->find($id);
            $manager->update($id, $request->only([
                'name', 'email', 'phone', 'birthday', 'address', 'gender'
            ]));
            $avatar = $request->file('avatar');
            $avatarFilename = $request->get('email') . '.' . $avatar->getClientOriginalExtension();
            $path = $this->managerRepository->saveImage(
                $avatar,
                $avatarFilename,
                config('default.avatar_size'),
                config('default.avatar_size')
            );
            $manager->avatar()->create([
                'path' => $path
            ]);
            DB::commit();

            return $this->successRouteRedirect('admin.managers.index');
        } catch (Exception $e) {
            DB::rollBack();

            return $this->failRouteRedirect($e->getMessage());
        }
    }

    public function destroy($id)
    {
        $result = $this->managerRepository->delete($id);

        if ($result) {
            return $this->successRouteRedirect('admin.managers.index');
        }
        return $this->failRouteRedirect();
    }

    public function restore($id)
    {
        $result = $this->managerRepository->restore($id);
        if ($result) {
            return $this->successRouteRedirect('admin.managers.index');
        }

        return $this->failRouteRedirect();
    }
}
