<?php

namespace App\Providers;

use App\Repositories\ClassRepository;
use App\Repositories\ClassRoomRepository;
use App\Repositories\ConfigRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\GradeRepository;
use App\Repositories\IClassRoomRepository;
use App\Repositories\IDepartmentRepository;
use App\Repositories\IGradeRepository;
use App\Repositories\IManagerRepository;
use App\Repositories\IScheduleDetailRepository;
use App\Repositories\IScheduleRepository;
use App\Repositories\ISpecializationRepository;
use App\Repositories\ISpecializationSubjectRepository;
use App\Repositories\IStudentRepository;
use App\Repositories\ISubjectRepository;
use App\Repositories\ITeacherRepository;
use App\Repositories\ManagerRepository;
use App\Repositories\ScheduleDetailRepository;
use App\Repositories\ScheduleRepository;
use App\Repositories\SpecializationRepository;
use App\Repositories\SpecializationSubjectRepository;
use App\Repositories\StudentRepository;
use App\Repositories\SubjectRepository;
use App\Repositories\TeacherRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    private $repositories = [
        ISubjectRepository::class => SubjectRepository::class,
        ISpecializationRepository::class => SpecializationRepository::class,
        IClassRoomRepository::class => ClassRoomRepository::class,
        IStudentRepository::class => StudentRepository::class,
        IScheduleRepository::class => ScheduleRepository::class,
        IDepartmentRepository::class => DepartmentRepository::class,
        IGradeRepository::class => GradeRepository::class,
        IScheduleDetailRepository::class => ScheduleDetailRepository::class,
        ITeacherRepository::class => TeacherRepository::class,
        IManagerRepository::class => ManagerRepository::class,
        ISpecializationSubjectRepository::class => SpecializationSubjectRepository::class,
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
