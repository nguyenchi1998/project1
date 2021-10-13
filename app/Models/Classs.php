<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classs extends Model
{
    protected $table = 'classes';

    protected $fillable = [
        'name'
    ];

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }

}
