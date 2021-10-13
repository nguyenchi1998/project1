<?php

namespace App\Repositories;

interface IRoleRepository
{
    public function all();

    public function create($arr);
}