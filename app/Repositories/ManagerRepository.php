<?php

namespace App\Repositories;

use App\Models\Manager;

class ManagerRepository extends Repository implements IManagerRepository
{
    public function __construct(Manager $model)
    {
        parent::__construct($model);
    }
}
