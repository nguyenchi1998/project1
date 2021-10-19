<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use ImageResize;

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

    public function where($key, $operator , $value)
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

    public function saveImage($file, $fileName, $path, $width = 100, $height = 100)
    {
        if (!file_exists($path)) {
            mkdir($path, 777, true);
        }
        $img = ImageResize::make($file->path());
        $img->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        })->save(config('default.path.media.avatar.teacher'), $fileName);

        return $img;
    }
}
