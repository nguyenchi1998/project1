<?php

namespace App\Providers;

use App\Repositories\ISpecializationRepository;
use App\Repositories\ISubjectRepository;
use App\Repositories\SpecializationRepository;
use App\Repositories\SubjectRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    private $repositories = [
        ISubjectRepository::class => SubjectRepository::class,
        ISpecializationRepository::class => SpecializationRepository::class
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
