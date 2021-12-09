<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Manager extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    protected $guarded = 'manager';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'gender',
        'birthday',
        'address',
        'phone',
        'type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function avatar()
    {
        return $this->morphOne(Media::class, 'mediable');
    }

    public function isNormalManager()
    {
        return $this->where('type', config('role.manager.normal'));
    }
}
