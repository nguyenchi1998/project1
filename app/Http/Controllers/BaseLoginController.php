<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BaseLoginController extends Controller
{
    protected $guard;

    public function __construct()
    {
        $this->middleware(['jwt.verify', 'auth.jwt'], ['except' => ['login']]);
    }

    public function login(Request $request)
    {
        if (!$token = auth($this->guard)
            ->attempt($request->only(['email', 'password']))) {
            return response()->json([
                'message' => 'login fail',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $this->respondWithToken($token);
    }

    public function profile()
    {
        return $this->successResponse(
            auth($this->guard)->user()
        );
    }

    public function logout()
    {
        auth($this->guard)->logout();

        return $this->successResponse(
            null,
            'logged out successfully'
        );
    }

    private function respondWithToken($token)
    {
        return $this->successResponse([
            'access_token' => 'Bearer ' . $token,
            'user' => auth($this->guard)->user(),
        ]);
    }
}
