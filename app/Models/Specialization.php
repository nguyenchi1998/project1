<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Specialization extends Model
{
    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class);
    }

}
