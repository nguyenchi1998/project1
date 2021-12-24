<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'type',
        'credit',
        'force',
        'semester',
        'department_id'
    ];

    public function basicSubjects()
    {
        return $this->whereType(config('subject.type.basic'));
    }

    public function specializationSubjects()
    {
        return $this->whereType(config('subject.type.specialization'));
    }

    public function specializations()
    {
        return $this->belongsToMany(Specialization::class)
            ->using(SpecializationSubject::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
