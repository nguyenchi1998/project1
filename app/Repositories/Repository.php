<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

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

    public function delete($id, $force = false)
    {
        $obj = $this->find($id);
        if ($force) {

            return $obj->forceDelete();
        }

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

    public function updateOrCreateMany($array)
    {
        foreach ($array as $item) {
            $this->model->updateOrCreate($item, $item);
        }
    }

    public function createMany($array)
    {
        return $this->model->insert($array);
    }

    public function whereIn($key = 'id', $values = [])
    {
        return $this->model->whereIn($key, $values);
    }

    public function where($key, $operator, $value)
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

    public function withTrashedModel()
    {
        return $this->model->withTrashed()->orderBy('deleted_at', 'asc')
            ->orderBy('id', 'desc');
    }

    public function saveImage($file, $fileName, $width, $height , $publicPath = 'storage')
    {
        dd($width);
        $pathImage = $file->storeAs(config('default.path.public'), $fileName);
        $path = str_replace(config('default.path.public'), '', $pathImage);
        $img = Image::make(storage_path(config('default.path.app_public') . $path));
        $img->resize($width, $height)->save(storage_path(config('default.path.app_public') . $path));

        return $path;
    }

    public function deleteImage($fileName)
    {
        return unlink(storage_path(config('default.path.app_public') .  $fileName));
    }

    public function updateOrCreate($filter, $array)
    {
        $this->model->updateOrCreate($filter, $array);
    }

    public function paginate()
    {
        return $this->model->paginate(config('config.paginate'));
    }

    public function restore($id)
    {
        return $this->model->where('id', $id)->restore();
    }
}
