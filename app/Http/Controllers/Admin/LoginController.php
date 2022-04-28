<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseLoginController;

class LoginController extends BaseLoginController
{
    protected $guard = 'manager';

    public function __construct()
    {
        $this->middleware(['jwt.verify', 'auth.jwt', 'access:manager'], ['except' => ['login']]);
    }
}
