<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;

class JwtMiddleware extends BaseMiddleware
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
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            $statusCode = Response::HTTP_NOT_FOUND;
            $error = [
                'success' => false,
            ];
            if ($e instanceof TokenInvalidException) {
                $error['message'] = 'token is invalid';
                $statusCode = Response::HTTP_FORBIDDEN;
            } else if ($e instanceof TokenExpiredException) {
                $error['message'] = 'token is expired';
                $statusCode = Response::HTTP_UNAUTHORIZED;
            } else if ($e instanceof TokenBlacklistedException) {
                $error['status'] = 'token is blacklisted';
                $statusCode = Response::HTTP_BAD_REQUEST;
            } else {
                $error['status'] =  'authorization token not found';
            }

            return response()->json($error, $statusCode);
        }
        return $next($request);
    }
}
