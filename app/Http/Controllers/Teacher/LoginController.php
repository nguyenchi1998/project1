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
        return view('teacher.login');
    }

    protected function guard()
    {
        return Auth::guard('teacher');
    }

    protected function loggedOut(Request $request)
    {
        return redirect()->route('teacher.loginShow');
    }
}
