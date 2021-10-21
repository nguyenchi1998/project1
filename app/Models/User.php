<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    protected $guarded = 'admin';

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
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function scopeIsSuperAdmin()
    {
        return in_array(config('common.roles.superAdmin'), $this->getRoleNames()->toArray());
    }

    public function scopeIsAdmin()
    {
        return in_array(config('common.roles.admin'), $this->getRoleNames()->toArray());
    }

    public function avatar()
    {
        return $this->morphOne(Media::class, 'mediable');
    }
}
