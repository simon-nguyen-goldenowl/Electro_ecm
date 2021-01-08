<?php

namespace App\Services;

use http\Env\Request;

interface IService
{
    public function getAll($query, $request);
    public function getById($id);
    public function update($id, $request);
    public function delete($id);
    public function create($request);
}
