<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class SpecializationSubject extends Pivot
{
    public function subject()
    {
        return $this->belongsTo(Subject::class)->withTrashed();
    }

    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }
}
