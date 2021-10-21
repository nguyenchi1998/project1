<?php

namespace App\Repositories;

use App\Models\Teacher;

class TeacherRepository extends Repository implements ITeacherRepository
{
    public function __construct(Teacher $model)
    {
        parent::__construct($model);
    }
}