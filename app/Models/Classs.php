<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classs extends Model
{
    protected $table = 'classes';

    protected $fillable = [
        'name',
        'specialization_id',
        'semester',
    ];

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'class_id');
    }

    public function subjects()
    {
        return $this->hasManyThrough(Subject::class, Schedule::class);
    }
}
