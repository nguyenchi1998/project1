<?php

namespace App\Repositories;

use App\Models\Classs;

class ClassRepository extends Repository implements IClassRepository
{
    public function __construct(Classs $model)
    {
        parent::__construct($model);
    }
}