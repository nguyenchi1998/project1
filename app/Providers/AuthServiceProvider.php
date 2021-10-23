<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use function foo\func;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::before(function ($user) {
            return $user->hasRole(config('common.roles.super_admin.name'));
        });
        Gate::define('isAdmin', function ($user, $permission = '') {
            return $user->hasRole(config('common.roles.admin.name'));
        });
        Gate::define('isTeacher', function ($user) {
            return $user->hasRole(config('common.roles.teacher.name'));
        });
    }
}
