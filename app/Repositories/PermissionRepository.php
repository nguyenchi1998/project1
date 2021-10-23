<?php

namespace App\Repositories;

use Spatie\Permission\Models\Permission;

class PermissionRepository implements IPermissionRepository
{
    public function all()
    {
        return Permission::all();
    }

    public function create($arr)
    {
        return Permission::create($arr);
    }

    public function whereNotIn($values)
    {
        return Permission::whereNotIn('name', $values);
    }

    public function findById($id)
    {
        return Permission::findById($id);
    }

    public function findByName($name)
    {
        return Permission::findByName($name);
    }

    public function where($attribute, $value)
    {
        return Permission::where($attribute, $value);
    }
}