<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Student extends Authenticatable
{
    use HasRoles;

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
        'department_id'
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
