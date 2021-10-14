<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends Repository implements IUserRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}