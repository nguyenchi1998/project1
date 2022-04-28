<?php

use Carbon\Carbon;

if (!function_exists('getNameSchedule')) {
    function getNameSchedule($id)
    {
        switch ($id) {
            case config('schedule.status.new'): {
                    $name = 'Mới Tạo';
                    break;
                }
            case config('schedule.status.progress'): {
                    $name = 'Đang Học';
                    break;
                }
            case config('schedule.status.finish'): {
                    $name = 'Học Xong';
                    break;
                }
            case config('schedule.status.marking'): {
                    $name = 'Vào Điểm';
                    break;
                }
            default: {
                    $name = 'Hoàn Thành';
                    break;
                }
        }

        return $name;
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
        return $date ?  Carbon::createFromDate($date)->format(config('config.format_date_show')) : '__/__/____';
    }
}

if (!function_exists('assetStorage')) {
    function assetStorage($path)
    {
        return asset('storage' . $path);
    }
}

if (!function_exists('range_semester')) {
    function range_semester($start, $end, $hasTitle = true, $currentSemester = null, $nextSemester = false)
    {
        $semesters = [];
        for ($i = $start; $i <= $end; $i++) {
            $title = $currentSemester ?
                ($currentSemester == $i ?
                    ' - Kỳ Hiện Tại'
                    : ($nextSemester && $currentSemester == $i - 1 ?
                        ' - Kỳ Tiếp Theo'
                        : ''
                    )
                )
                : '';
            $semesters[$i] = ($hasTitle ? 'Kỳ ' : '') . $i . $title;
        }

        return $semesters;
    }
}

if (!function_exists('result_mark')) {
    function result_mark($activityMark, $middleMark, $finalMark)
    {
        $mark = ($activityMark + $middleMark * 4 + $finalMark * 5) / 10;

        return $mark - floor($mark) < 0.5 ? floor($mark) : ($mark - floor($mark) > 0.5 ? ceil($mark) : $mark);
    }
}


if (!function_exists('result_schedule_detail')) {
    function result_schedule_detail($activityMark, $middleMark, $finalMark)
    {
        if (!$activityMark || !$middleMark || !$finalMark) {
            $result = config('schedule.detail.status.result.relearn');
        } else {
            $averageMark = result_mark($activityMark, $middleMark, $finalMark);
            if ($averageMark >= 4) {
                $result = config('schedule.detail.status.result.pass');
            } else {
                $result = config('schedule.detail.status.result.retest');
            }
        }

        return $result;
    }
}

if (!function_exists('modelTrash')) {
    function modelTrash($model)
    {
        return $model->trashed() ? 'text-decoration-line-through' : '';
    }
}
