<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class Repository implements IRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function update($id, $array)
    {
        $obj = $this->find($id);

        return $obj->update($array);
    }

    public function delete($id)
    {
        $obj = $this->find($id);

        return $obj->delete();
    }

    public function get($key = '*')
    {
        return $this->model->get($key);
    }

    public function create($array)
    {
        return $this->model->create($array);
    }

    public function whereIn($key = 'id', $values = [])
    {
        return $this->model->whereIn($key, $values);
    }

    public function where($key, $value, $operator = '=')
    {
        return $this->model->where($key, $operator, $value);
    }

    public function with($relation)
    {
        return $this->model->with($relation);
    }

    public function model()
    {
        return $this->model;
    }
}
