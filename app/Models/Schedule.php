<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{


    protected $table = 'schedules';

    protected $fillable = [
        'code',
        'teacher_id',
        'subject_id',
        'specialization_subject_id',
        'name',
        'start_time',
        'end_time',
        'class_room_id',
        'schedule_time',
        'status',
        'semester',
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

    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class);
    }

    public function newSchedule()
    {
        return $this->whereStatus(config('schedule.status.new'));
    }

    public function classSchedule()
    {
        return $this->where('class_room_id', '!=', null);
    }

    public function freeSchedule()
    {
        return $this->where('class_room_id', null);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
