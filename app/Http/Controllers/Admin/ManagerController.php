<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateManagerRequest;
use App\Http\Resources\ManagerResource;
use App\Repositories\IManagerRepository;
use Carbon\Carbon;
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
            ->isNormalManager()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('email', 'like', '%' . $keyword . '%')
                    ->orWhere('phone', $keyword);
            })
            ->get();

        return ManagerResource::collection($managers);
    }

    public function show($id)
    {
        $manager = $this->managerRepository->findOrFail($id);

        return new ManagerResource($manager);
    }

    public function store(CreateManagerRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = array_merge($request->only([
                'name',
                'email',
                'phone',
                'address',
                'gender'
            ]), [
                'birthday' => Carbon::createFromFormat('d/m/Y', $request->get('birthday')),
                'password' => Hash::make(config('default.auth.password'))
            ]);
            $manager = $this->managerRepository->create($data);
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
        $manager = $this->managerRepository->findOrFail($id);
        try {
            DB::beginTransaction();
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
        } catch (Exception $e) {
            DB::rollBack();

            return $this->failRouteRedirect($e->getMessage(), 404);
        }
    }

    public function destroy($id)
    {
        $result = $this->managerRepository->delete($id);

        if ($result) {
            return $this->successRouteRedirect();
        }
        return $this->failRouteRedirect();
    }

    public function restore($id)
    {
        $result = $this->managerRepository->restore($id);
        if ($result) {
            return $this->successRouteRedirect();
        }

        return $this->failRouteRedirect();
    }
}
