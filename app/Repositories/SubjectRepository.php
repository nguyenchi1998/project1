<?php

namespace App\Repositories;

use App\Models\Subject;

class SubjectRepository extends Repository implements ISubjectRepository
{
    public function __construct(Subject $model)
    {
        parent::__construct($model);
    }
}