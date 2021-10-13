<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Schedule extends Pivot
{
    protected $table = 'schedules';

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
}
