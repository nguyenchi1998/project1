<?php

namespace App\Providers;

use App\Models\Schedule;
use App\Policies\SchedulePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Schedule::class => SchedulePolicy::class,
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
            return $user->hasRole(config('role.roles.super_admin.name'));
        });
        Gate::define('isAdmin', function ($user, $permission = '') {
            return $user->hasRole(config('role.roles.admin.name'));
        });
        Gate::define('isTeacher', function ($user) {
            return $user->hasRole(config('role.roles.teacher.name'));
        });
    }
}
