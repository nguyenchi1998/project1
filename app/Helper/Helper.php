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

if (!function_exists('range_semester')) {
    function range_semester($start, $end, $hasTitle = true)
    {
        $semesters = [];
        for ($i = $start; $i <= $end; $i++) {
            $semesters[$i] = ($hasTitle ? 'Kỳ ' : '') . $i;
        }

        return $semesters;
    }
}

if (!function_exists('result_schedule_detail')) {
    function result_schedule_detail($activityMark, $middleMark, $finalMark)
    {
        if (!$activityMark || !$middleMark || !$finalMark) {
            $result = config('schedule_detail.status.result.relearn');
        } else {
            $averageMark = ($activityMark + $middleMark * 4 + $finalMark * 5) / 10;
            if ($averageMark >= 4) {
                $result = config('schedule_detail.status.result.pass');
            } else {
                $result = config('schedule_detail.status.result.retest');
            }
        }

        return $result;
    }
}

if (!function_exists('render_delete_model')) {
    function modelTrash($model)
    {
        return $model->trashed() ? 'text-decoration-line-through' : '';
    }
}
