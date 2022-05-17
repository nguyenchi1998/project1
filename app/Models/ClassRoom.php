<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    protected $fillable = [
        'name',
    ];

    public function students()
    {
        return $this->hasMany(Student::class, 'class_room_id');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'class_room_id');
    }

    public function newbieClass()
    {
        return $this->where('semester', '<=', config('config.class_register_limit_semester'));
    }
}
