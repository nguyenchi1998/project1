<?php

namespace App\Repositories;

interface IRepository
{
    public function all();

    public function allWithTrashed();

    public function find($id);

    public function findOrFail($id);

    public function update($id, $array);

    public function delete($id, $force = false);

    public function withTrashedModel();

    public function restore($id);

    public function get($key = '*');

    public function create($array);

    public function createMany($array);

    public function whereIn($key = 'id', $values = []);

    public function where($key, $operator, $value);

    public function with($relation);

    public function saveImage($file, $fileName, $width, $height, $publicPath = 'storage');

    public function deleteImage($fileName);

    public function updateOrCreate($filter, $array);

    public function paginate();

    public function updateOrCreateMany($array);

    public function model();
}
