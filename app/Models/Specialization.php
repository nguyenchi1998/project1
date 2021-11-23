<?php

namespace App\Models;

use App\Scopes\LastEloquentScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Specialization extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'min_credit',
        'max_semester',
        'department_id',
    ];

    protected static function boot()
    {
        parent::boot();
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class)
            ->using(SpecializationSubject::class)
            ->withPivot(['semester', 'force', 'id']);
    }

    public function classes()
    {
        return $this->hasMany(Classs::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
