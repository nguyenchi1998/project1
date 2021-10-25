<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('get_guard')) {
    function get_guard()
    {
        foreach (config('config.guard') as $key => $guard) {
            if (Auth::guard($guard)->check()) {
                return $guard;
            }
        }
    }
}

if (!function_exists('getNameSchedule')) {
    function getNameSchedule($id)
    {
        return array_flip(config('config.status.schedule'))[$id];
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

if (!function_exists('checkForceSubject')) {
    function checkForceSubject($subjects, $subjectCheck)
    {
        return $subjects->contains(function ($item) use ($subjectCheck) {
            return $item->id == $subjectCheck->id
                && $item->pivot->force == 1;
        });
    }
}
