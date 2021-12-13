<?php

namespace App\Repositories;

use App\Models\SpecializationSubject;

class SpecializationSubjectRepository extends Repository implements ISpecializationSubjectRepository
{
    public function __construct(SpecializationSubject $model)
    {
        parent::__construct($model);
    }
}
