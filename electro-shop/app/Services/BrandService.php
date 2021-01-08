<?php

namespace App\Services;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandService extends CommonService
{
    public function getModel()
    {
        return Brand::class;
    }
    public function getAllBrands(Request $request)
    {
        $query = Brand::query();
        return $this->getAll($query, $request);
    }
}
