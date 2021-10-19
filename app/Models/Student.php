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
        'can_register_credit',
        'grade_id',
        'class_id',
    ];

    public function class()
    {
        return $this->belongsTo(Classs::class);
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
}
