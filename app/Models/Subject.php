<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subject extends Model
{
    protected $fillable = [
        'name',
        'type',
    ];
    
    public function specializations(): BelongsToMany
    {
        return $this->belongsToMany(Specialization::class);
    }
}
