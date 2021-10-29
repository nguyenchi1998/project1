<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use SoftDeletes;

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
        return $this->whereHas('roles', function ($query) {
            $query->whereName(config('config.roles.super_admin.name'));
        });
    }

    public function scopeIsAdmin()
    {
        return $this->whereHas('roles', function ($query) {
            $query->whereName(config('config.roles.admin.name'));
        });
    }

    public function avatar()
    {
        return $this->morphOne(Media::class, 'mediable');
    }

    public function hasAdminRole()
    {
        return $this->hasRole(config('config.roles.admin.name'), config('config.roles.admin.guard'));
    }

    public function hasSuperAdminRole()
    {
        return $this->hasRole(config('config.roles.super-admin.name'), config('config.roles.super-admin.guard'));
    }
}
