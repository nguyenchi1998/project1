<?php

namespace App\Repositories;

use App\Models\Schedule;

class ScheduleRepository extends Repository implements IScheduleRepository
{
    public function __construct(Schedule $model)
    {
        parent::__construct($model);
    }
}