<?php

namespace App\Repositories;

use App\Models\Specialization;

class SpecializationRepository extends Repository implements ISpecializationRepository
{
    public function __construct(Specialization $model)
    {
        parent::__construct($model);
    }
}
