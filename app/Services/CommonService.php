<?php

namespace App\Services;

use App\Enums\DefaultType;
use App\Enums\ESStatusType;
use App\Enums\ResultType;
use http\Env\Request;

abstract class CommonService implements IService
{
    //store corresponding model
    protected $model;
    public function __construct()
    {
        $this->model = app()->make(
            $this->getModel()
        );
    }

    //get corresponding model
    abstract public function getModel();
    /**
     * Set model
     */
    public function getAll($query, $request)
    {
        if (!isset($request['limit'])) {
            $request['limit'] = DefaultType::default_limit; //set default value for pagination
        }
        if (!isset($request['column'])) {
            return $query-> paginate($request['limit']);
        }
        return $query->orderBy($request['column'], $request['sort'])->paginate($request['limit']);
    }
    public function getById($id)
    {
        $result =  $this->model->find($id);
        return $result;
    }

    public function update($id, $request)
    {
        $request['es_status'] =  ESStatusType::IsUpdated;
        $data = $this->model->find($id);
        if ($data) {
            $data->update($request);
        }
        return $data;
    }

    public function delete($id)
    {
        if ($this->model->where('id', $id)->delete()) {
            $data = ResultType::Success;
        } else {
            $data = ResultType::Failure;
        }
        return $data;
    }

    public function create($request)
    {
        return $this->model->create($request);
    }
}
