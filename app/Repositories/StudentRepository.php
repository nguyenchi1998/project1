<?php

namespace App\Repositories;

use App\Models\Student;

class StudentRepository extends Repository implements IStudentRepository
{
    public function __construct(Student $model)
    {
        parent::__construct($model);
    }
}