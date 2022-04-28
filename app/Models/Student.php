<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Student extends Authenticatable implements JWTSubject
{
    use SoftDeletes;

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
        'avatar',
        'class_room_id',
        'department_id',
        'can_register_credit',
    ];

    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class);
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

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
