<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    const REGISTER_CREDIT_OPEN_STATUS = 'register_credit';

    protected $fillable = [
        'key',
        'value'
    ];
}
