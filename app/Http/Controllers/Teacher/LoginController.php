<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/teacher';

    public function __construct()
    {
        $this->middleware('guest:teacher')->except('logout');
    }

    public function showLoginForm()
    {
        Auth::guard('manager')->logout();
        Auth::guard('student')->logout();
        return view('teacher.login');
    }

    protected function guard()
    {
        return Auth::guard('teacher');
    }

    protected function loggedOut()
    {
        return redirect()->route('teacher.loginShow');
    }
}
