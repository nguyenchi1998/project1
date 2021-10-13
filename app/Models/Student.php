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
    ];

    public function class()
    {
        return $this->belongsTo(Classs::class);
    }
}
