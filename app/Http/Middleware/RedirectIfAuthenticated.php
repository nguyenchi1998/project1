<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    const ADMIN_GUARD = 'admin';
    const TEACHER_GUARD = 'teacher';

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if ($guard == config('role.guard.admin')) {
                return redirect()->route('admin.home');
            } elseif ($guard == config('role.guard.teacher')) {
                return redirect()->route('teacher.home');
            } else {
                return redirect()->route('student.home');
            }
        }

        return $next($request);
    }
}
