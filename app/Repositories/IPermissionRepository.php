<?php

namespace App\Repositories;


interface IPermissionRepository
{
    public function all();

    public function create($arr);

    public function whereNotIn($values);

    public function where($attribute, $value);

    public function findById($id);

    public function findByName($name);
}