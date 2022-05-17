<?php

namespace App\Repositories;

use App\Models\ClassRoom;

class ClassRoomRepository extends Repository implements IClassRoomRepository
{
    public function __construct(ClassRoom $model)
    {
        parent::__construct($model);
    }
}
