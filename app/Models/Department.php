<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'name',
        'manager_id',
        'next_manager_id',
        'next_manager_status',
    ];

    public function manager()
    {
        return $this->hasOne(User::class, 'manager_id');
    }

    public function nextManager()
    {
        return $this->hasOne(User::class, 'next_manager_id');
    }
}
