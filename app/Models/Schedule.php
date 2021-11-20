<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use SoftDeletes;

    protected $table = 'schedules';

    protected $fillable = [
        'teacher_id',
        'specialization_subject_id',
        'name',
        'start_time',
        'end_time',
        'class_id',
        'schedule_time',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($schedule) {
            $schedule->scheduleDetails()->delete();
        });
    }

    public function scheduleDetails()
    {
        return $this->hasMany(ScheduleDetail::class, 'schedule_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function class()
    {
        return $this->belongsTo(Classs::class);
    }

    public function newSchedule()
    {
        return $this->whereStatus(config('schedule.status.new'));
    }

    public function classSchedule()
    {
        return $this->where('class_id', '!=', null);
    }

    public function freeSchedule()
    {
        return $this->where('class_id', null);
    }

    public function specializationSubject()
    {
        return $this->belongsTo(SpecializationSubject::class, 'specialization_subject_id');
    }
}
