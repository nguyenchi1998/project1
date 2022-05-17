<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    protected $guarded = 'student';

    protected $fillable = [
        'name',
        'email',
        'gender',
        'birthday',
        'phone',
        'password',
        'remember_token',
        'grade_id',
        'class_room_id',
        'department_id',
        'can_register_credit',
    ];

    public function class()
    {
        return $this->belongsTo(ClassRoom::class);
    }

    public function avatar()
    {
        return $this->morphOne(Media::class, 'mediable');
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function schedules()
    {
        return $this->hasManyThrough(Schedule::class, Specialization::class);
    }

    public function scheduleDetails()
    {
        return $this->hasMany(ScheduleDetail::class);
    }
}
