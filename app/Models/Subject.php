<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subject extends Model
{
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
        return $this->whereType(config('common.subject.type.basic'));
    }

    public function specializationSubjects()
    {
        return $this->where('type', '!=', config('common.subject.type.basic'));
    }

    public function specializations(): BelongsToMany
    {
        return $this->belongsToMany(Specialization::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'subject_teacher', 'teacher_id', 'subject_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
