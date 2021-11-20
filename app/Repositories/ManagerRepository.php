<?php

namespace App\Repositories;

use App\Models\User;

class ManagerRepository extends Repository implements IManagerRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
