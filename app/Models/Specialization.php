<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    protected $fillable = [
        'name',
        'min_credit',
        'total_semester',
    ];

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

    public function specializationSubject()
    {
        return $this->subjects()->where('type', '!=', config('common.subject.type.basic'));
    }

    public function classes()
    {
        return $this->hasMany(Classs::class);
    }

}
