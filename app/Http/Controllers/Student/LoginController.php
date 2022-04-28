<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\BaseLoginController;

class LoginController extends BaseLoginController
{
    protected $guard = 'student';

    public function __construct()
    {
        $this->middleware(['jwt.verify', 'auth.jwt', 'access:student'], ['except' => ['login']]);
    }
}
