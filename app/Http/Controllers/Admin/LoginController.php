<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTFactory;
use JWTAuth;

class LoginController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['jwt.verify', 'auth.jwt'], ['except' => ['login']]);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'message' => 'login fail',
            ], 401);
        }


        return $this->respondWithToken($token);
    }


    public function profile()
    {
        return response()->json(
            auth()->user()
        );
    }

    public function logout()
    {
        auth(config('role.guard.manager'))->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'token_type' => 'Bearer',
            'access_token' => $token,
        ]);
    }
}
