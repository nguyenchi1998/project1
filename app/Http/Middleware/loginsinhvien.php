<?php

namespace App\Http\Middleware;

use Closure;

class loginsinhvien
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->session()->has('tk_sv'))
        {
            return $next($request);
        }
        else
        {
            return redirect()->route('login');
        }
    }
}
