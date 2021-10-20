<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Teacher extends Authenticatable
{
    protected $guarded ='teacher';

    protected $fillable = [
        'email',
        'password',
        'remember_token',
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
