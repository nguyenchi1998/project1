<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class ActionAccess extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        foreach ($guards as $guard) {
            if (auth($guard)->user()) {
                return $next($request);
            }
        }
        return response()->json([
            'success' => false,
            'message' => 'access deny'
        ], Response::HTTP_FORBIDDEN);
    }
}
