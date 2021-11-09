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
            $query->whereName(config('role.rolessuper_admin.name'));
        });
    }

    public function scopeIsAdmin()
    {
        return $this->whereHas('roles', function ($query) {
            $query->whereName(config('role.rolesadmin.name'));
        });
    }

    public function avatar()
    {
        return $this->morphOne(Media::class, 'mediable');
    }

    public function hasAdminRole()
    {
        return $this->hasRole(config('role.rolesadmin.name'), config('role.rolesadmin.guard'));
    }

    public function hasSuperAdminRole()
    {
        return $this->hasRole(config('role.rolessuper-admin.name'), config('role.rolessuper-admin.guard'));
    }
}
