<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/manager';

    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm()
    {
        Auth::guard('teacher')->logout();
        Auth::guard('student')->logout();
        return view('admin.login');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    protected function loggedOut(Request $request)
    {
        return redirect()->route('admin.loginShow');
    }
}