<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
        return $this->whereType(config('config.subject.type.basic'));
    }

    public function specializationSubjects()
    {
        return $this->where('type', '!=', config('config.subject.type.basic'));
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
