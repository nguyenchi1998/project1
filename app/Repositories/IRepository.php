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

    public function whereIn($key = 'id', $values = []);

    public function where($key, $operator, $value);

    public function with($relation);

    public function saveImage($file, $fileName, $path, $width = 100, $height = 100);
}
