<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classs extends Model
{
    use SoftDeletes;

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
        return $this->belongsTo(Specialization::class)->withTrashed();
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'class_id');
    }

    public function newbieClass()
    {
        return $this->where('semester', '<=', config('config.class_register_limit_semester'));
    }
}
