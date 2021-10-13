<?php

namespace App\Repositories;

use Spatie\Permission\Models\Role;

class RoleRepository implements IRoleRepository
{
    public function all()
    {
        return Role::all();
    }

    public function create($arr)
    {
        return Role::create($arr);
    }
}