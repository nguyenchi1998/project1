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
        'total_semester',
        'department_id',
    ];

    protected static function boot()
    {
        parent::boot();
        self::addGlobalScope(new LastEloquentScope());
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class)->withPivot('force');
    }

    public function specializationSubject()
    {
        return $this->subjects()->where('type', '!=', config('config.subject.type.basic'));
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
