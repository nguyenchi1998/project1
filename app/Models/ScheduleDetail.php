<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScheduleDetail extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'schedule_id',
        'student_id',
        'specialization_id',
        'semester',
        'subject_id',
        'activity_mark',
        'middle_mark',
        'final_mark',
        'result_status',
        'register_status',
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }
}
