<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateManager;
use App\Http\Resources\ManagerCollection;
use App\Repositories\IManagerRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Exception\NotFoundException;

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
            ->isNormalManager()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('phone', $keyword)
                    ->orWhere('email', 'like', '%' . $keyword . '%');
            })
            ->get();

        return ManagerCollection::collection($managers);
    }

    public function show($id)
    {
        $manager = $this->managerRepository->find($id);

        return new ManagerCollection($manager);
    }

    public function store(CreateManager $request)
    {
        try {
            $data =  $request->only([
                'name', 'email', 'phone', 'birthday', 'address', 'gender'
            ]);
            DB::beginTransaction();
            $manager = $this->managerRepository->create(
                array_merge(
                    $data,
                    ['password' => Hash::make(config('default.auth.password'))]
                )
            );
            $avatar = $request->file('avatar');
            if ($avatar) {
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
            }
            DB::commit();

            return $this->successRouteRedirect($data);
        } catch (Exception $e) {
            DB::rollBack();

            return $this->failRouteRedirect($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $manager = $this->managerRepository->findOrFail($id);
            $data = $request->only([
                'name', 'phone', 'birthday', 'address', 'gender'
            ]);
            $manager->update($data);
            $avatar = $request->file('avatar');
            if ($avatar) {
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
            }
            DB::commit();

            return $this->successRouteRedirect($data);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();

            return $this->failRouteRedirect($e->getMessage(), 404);
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
