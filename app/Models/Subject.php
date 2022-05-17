<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'name',
        'code',
        'type',
    ];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class);
    }
}
