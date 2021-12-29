<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Teacher extends Authenticatable implements JWTSubject
{
    use SoftDeletes;

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
        'next_department_status',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
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
        return $this->hasMany(Schedule::class);
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
