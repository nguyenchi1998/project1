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
        'subject_id',
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

    public function newSchedule()
    {
        return $this->whereStatus(config('config.status.schedule.new'));
    }

    public function classSchedule()
    {
        return $this->where('class_id', '!=', null);
    }

    public function freeSchedule()
    {
        return $this->where('class_id', null);
    }
}
