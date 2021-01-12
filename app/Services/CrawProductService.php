<?php

namespace App\Services;

use App\Models\CrawlProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class CrawProductService extends CommonService
{
    public function getModel()
    {
        return CrawlProduct::class;
    }
    public function getAllCrawlProducts($request)
    {
        $query = $this->filterColumn($request);
        $result = $this->getAll($query, $request);
        return $result;
    }
    public function filterColumn(Request $request)
    {
        $result = CrawlProduct::class
            ->category($request)
            ->brand($request);
        return $result;
    }
    public function changeCate(){

    }
}
