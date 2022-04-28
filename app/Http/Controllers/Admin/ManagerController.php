<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ManagerRequest;
use App\Http\Resources\ManagerResource;
use App\Repositories\IManagerRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
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
                    ->orWhere('email', 'like', '%' . $keyword . '%')
                    ->orWhere('phone', $keyword);
            })
            ->get();

        return ManagerResource::collection($managers);
    }

    public function show($uuid)
    {
        $manager = $this->managerRepository->find($uuid, true);

        return new ManagerResource($manager);
    }

    public function store(ManagerRequest $request)
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
                'password' => Hash::make(config('default.auth.password')),
                'uuid' => Str::uuid()
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

            return $this->successResponse($data);
        } catch (Exception $e) {
            DB::rollBack();

            return $this->errorResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $manager = $this->managerRepository->find($id, true);
            if (!$manager) {
                throw new NotFoundException();
            }
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

            return $this->successResponse($data);
        } catch (Exception $e) {
            DB::rollBack();

            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    public function destroy($id)
    {
        $result = $this->managerRepository->delete($id);

        if ($result) {
            return $this->successResponse();
        }
        return $this->errorResponse();
    }

    public function restore($uuid)
    {
        $result = $this->managerRepository->restore($uuid);
        if ($result) {
            return $this->successResponse();
        }

        return $this->errorResponse();
    }
}
