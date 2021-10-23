<?php

namespace App\Repositories;


interface IRoleRepository
{
    public function all();

    public function create($arr);

    public function whereNotIn($values);

    public function findById($id);

    public function findByName($name, $guard);

    public function assignPermissions($roleId, $permissions);
}