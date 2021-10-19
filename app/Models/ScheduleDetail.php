<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleDetail extends Model
{
    protected $fillable = [
        'schedule_id',
        'student_id',
        'subject_id',
        'activity_mark',
        'middle_mark',
        'final_mark',
        'result',
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
