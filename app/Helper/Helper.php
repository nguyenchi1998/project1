<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

if (!function_exists('get_guard')) {
    function get_guard()
    {
        foreach (config('role.guard') as $key => $guard) {
            if (Auth::guard($guard)->check()) {
                return $guard;
            }
        }
    }
}

if (!function_exists('getNameSchedule')) {
    function getNameSchedule($id)
    {
        return array_flip(config('schedule.status'))[$id];
    }
}

if (!function_exists('checkFinishMark')) {
    function checkFinishMark($marks)
    {
        return array_search(function ($value) {
            return !empty($value['activity_mark'])
                && !empty($value['middle_mark'])
                && !empty($value['final_mark']);
        }, $marks);
    }
}

if (!function_exists('formatDateShow')) {
    function formatDateShow($date)
    {
        return Carbon::createFromDate($date)->format(config('config.format_date_show'));
    }
}

if (!function_exists('assetStorage')) {
    function assetStorage($path)
    {
        return asset('storage' . $path);
    }
}
