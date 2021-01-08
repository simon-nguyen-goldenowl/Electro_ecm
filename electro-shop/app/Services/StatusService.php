<?php

namespace App\Services;

use App\Models\Status;
use Illuminate\Http\Request;

class StatusService extends CommonService
{
    public function getModel()
    {
        return Status::class;
    }
    public function getAllStatus(Request $request)
    {
        $query = $this->filterColumn($request);
        $result = $this->getAll($query, $request);
        return $result;
    }
    private function filterColumn(Request $request)
    {
        $query = Status::query()->orderStatus($request)
                                ->shippingStatus($request)
                                ->paymentStatus($request);
        return $query;
    }
}
