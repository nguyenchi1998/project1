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

    public function whereNotIn($values)
    {
        return Role::whereNotIn('name', $values);
    }

    public function findById($id)
    {
        return Role::findById($id);
    }

    public function findByName($name)
    {
        return Role::findByName($name);
    }
}