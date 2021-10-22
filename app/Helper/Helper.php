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

if (!function_exists('getNameSchedule')) {
    function getNameSchedule($id)
    {
        return array_flip(config('common.status.schedule'))[$id];
    }
}

if (!function_exists('chexkFinishMark')) {
    function chexkFinishMark($marks)
    {
        return array_search(function ($value) {
            return !empty($value['activity_mark']) && !empty($value['middle_mark']) && !empty($value['final_mark']);
        }, $marks);
    }
}
