<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Pivot
{
    use SoftDeletes;

    protected $table = 'schedules';

    protected $fillable = [
        'teacher_id',
        'subject_id',
        'name',
        'start_time',
        'end_time',
        'class_id',
    ];

    public function scheduleDetails()
    {
        return $this->hasMany(ScheduleDetail::class, 'schedule_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function class()
    {
        return $this->belongsTo(Classs::class);
    }
}
