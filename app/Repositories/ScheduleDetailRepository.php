<?php

namespace App\Repositories;

use App\Models\ScheduleDetail;

class ScheduleDetailRepository extends Repository implements IScheduleDetailRepository
{
    public function __construct(ScheduleDetail $model)
    {
        parent::__construct($model);
    }
}
