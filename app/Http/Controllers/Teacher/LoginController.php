<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\BaseLoginController;

class LoginController extends BaseLoginController
{
    protected $guard = 'teacher';

    public function __construct()
    {
        $this->middleware(['jwt.verify', 'auth.jwt', 'access:teacher'], ['except' => ['login']]);
    }
}
