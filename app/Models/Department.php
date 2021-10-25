<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'manager_id',
        'next_manager_id',
        'next_manager_status',
    ];

    public function manager()
    {
        return $this->hasOne(Teacher::class, 'manager_id');
    }

    public function nextManager()
    {
        return $this->hasOne(User::class, 'next_manager_id');
    }

    public function specializations()
    {
        return $this->hasMany(Specialization::class);
    }

    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
}
