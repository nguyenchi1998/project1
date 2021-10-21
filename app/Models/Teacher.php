<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Teacher extends Authenticatable
{
    use HasRoles;

    protected $guarded = 'teacher';

    protected $fillable = [
        'name',
        'email',
        'password',
        'gender',
        'birthday',
        'address',
        'phone',
        'department_id',
        'next_department_id',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function nextDepartment()
    {
        return $this->belongsTo(Department::class, 'next_department_id');
    }

    public function avatar()
    {
        return $this->morphOne(Media::class, 'mediable');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

    public function schedules()
    {
        return $this->hasMany(Subject::class);
    }

    public function scopeIsTeacher()
    {
        return in_array(config('common.roles.teacher'), $this->getRoleNames()->toArray());
    }
}
