<?php

namespace App\Repositories;

use App\Models\Department;
use App\Models\Schedule;

class DepartmentRepository extends Repository implements IDepartmentRepository
{
    public function __construct(Department $model)
    {
        parent::__construct($model);
    }
}