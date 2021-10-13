<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('get_guard')) {
    function get_guard()
    {
        foreach (config('common.guard') as $key => $guard) {
            if (Auth::guard($guard)->check()) {
                return $guard;
            }
        }
    }
}