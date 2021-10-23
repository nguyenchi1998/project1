<?php

namespace App\Repositories;

interface IRepository
{
    public function all();

    public function find($id);

    public function update($id, $array);

    public function delete($id);

    public function get($key = '*');

    public function create($array);

    public function createMany($array);

    public function whereIn($key = 'id', $values = []);

    public function where($key, $operator, $value);

    public function with($relation);

    public function saveImage($file, $fileName, $width = 100, $height = 100, $publicPath = 'storage');

    public function updateOrCreate($filter, $array);

    public function paginate();
}
