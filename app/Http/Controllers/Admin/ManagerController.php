<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\IManagerRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
            ->paginate(config('common.paginate'));

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
            $student = $this->managerRepository->create(array_merge($request->only([
                'name', 'email', 'phone', 'birthday', 'address', 'gender'
            ]), ['password' => Hash::make(config('default.auth.password'))]));
            $avatar = $request->file('avatar');
            $avatarFilename = $student->email . '.' . $avatar->getClientOriginalExtension();
            $path = $this->managerRepository->saveImage(
                $avatar,
                $avatarFilename,
                100,
                100
            );
            $student->avatar()->create([
                'path' => $path
            ]);
            $adminRole = $this->roleRepository->findByName(
                config('common.roles.admin.name'),
                config('common.roles.admin.guard'));
            $student->assignRole($adminRole);
            DB::commit();

            return redirect()->route('admin.managers.index');
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withErrors(['msg' => $e->getMessage()]);
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
        $manager = $this->managerRepository->find($id);

        return view('admin.manager.edit', compact('manager'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->managerRepository->update($id, $request->only([
                'name', 'email', 'phone', 'birthday', 'address', 'gender'
            ]));
            $student = $this->managerRepository->find($id);
            $avatar = $request->file('avatar');
            $avatarFilename = $request->get('email') . '.' . $avatar->getClientOriginalExtension();
            $path = $this->managerRepository->saveImage(
                $avatar,
                $avatarFilename,
                100,
                100
            );
            $student->avatar()->create([
                'path' => $path
            ]);
            DB::commit();

            return redirect()->route('admin.managers.index');
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withErrors(['msg' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $result = $this->managerRepository->delete($id);

        if ($result) {
            return redirect()->route('admin.managers.index');
        }
        return redirect()->route('admin.managers.index')->withErrors(['msg' => 'Delete Error']);
    }
}
