<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Teacher extends Authenticatable
{


    protected $guarded = 'teacher';

    protected $fillable = [
        'name',
        'email',
        'password',
        'gender',
        'birthday',
        'address',
        'phone',
        'professional_group_id',
        'avatar',
    ];

    public function professionalGroup()
    {
        return $this->belongsTo(ProfessionalGroup::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
