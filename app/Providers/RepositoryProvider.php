<?php

namespace App\Providers;

use App\Repositories\ClassRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\IClassRepository;
use App\Repositories\IDepartmentRepository;
use App\Repositories\IPermissionRepository;
use App\Repositories\IRoleRepository;
use App\Repositories\IScheduleRepository;
use App\Repositories\ISpecializationRepository;
use App\Repositories\IStudentRepository;
use App\Repositories\ISubjectRepository;
use App\Repositories\IUserRepository;
use App\Repositories\PermissionRepository;
use App\Repositories\RoleRepository;
use App\Repositories\ScheduleRepository;
use App\Repositories\SpecializationRepository;
use App\Repositories\StudentRepository;
use App\Repositories\SubjectRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    private $repositories = [
        ISubjectRepository::class => SubjectRepository::class,
        ISpecializationRepository::class => SpecializationRepository::class,
        IClassRepository::class => ClassRepository::class,
        IStudentRepository::class => StudentRepository::class,
        IUserRepository::class => UserRepository::class,
        IRoleRepository::class => RoleRepository::class,
        IPermissionRepository::class => PermissionRepository::class,
        IScheduleRepository::class => ScheduleRepository::class,
        IDepartmentRepository::class => DepartmentRepository::class,
    ];

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->repositories as $key => $value) {
            $this->app->bind($key, $value);
        }
    }
}
