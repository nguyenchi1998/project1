<?php

namespace App\Repositories;

use App\Models\Grade;

class GradeRepository extends Repository implements IGradeRepository
{
    public function __construct(Grade $model)
    {
        parent::__construct($model);
    }
}
