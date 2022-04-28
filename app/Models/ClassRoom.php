<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassRoom extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'specialization_id',
        'semester',
    ];

    public function students()
    {
        return $this->hasMany(Student::class, 'class_room_id');
    }

    public function specialization()
    {
        return $this->belongsTo(Specialization::class)
            ->withTrashed();
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'class_room_id');
    }

    public function newbieClass()
    {
        return $this->where('semester', '<=', config('config.class_register_limit_semester'));
    }

    public function scopeInprogressClass($query, $finish = false)
    {
        return $query->where('finish', $finish);
    }
}
