<?php

namespace App\Services;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProductService extends CommonService
{
    public function getModel()
    {
        return Product::class;
    }
    public function getAllProducts(Request $request)
    {
        $query = $this->filterColumn($request);
        $result = $this->getAll($query, $request);
        return $result;
    }
    public function generateProductcode($request)
    {
        if (!isset($request['code'])) {
            $id = Product::select('id')->max('id') + 1;
            $result = strval($id);
            $code = 'U' . str_pad($result, 4, 0, STR_PAD_LEFT);
            return $code;
        }
    }
    public function create($request)
    {
        $request['code'] = $this->generateProductcode($request);
        return parent::create($request);
    }
    public function filterColumn(Request $request)
    {
        $result = Product::with('category')
                        ->with('brand')
                        ->category($request)
                        ->brand($request)
                        ->brandId($request)
                        ->name($request)
                        ->newest($request)
                        ->topselling($request)
                        ->amount($request)
                        ->price($request);
        return $result;
    }
    public function getById($id)
    {
        $data = Product::with('category')
                         ->with('brand')->find($id);
        return $data;
    }

    public function getRelatedProduct(Request $request, $id)
    {
        $targetProduct = $this->getById($id);
        $brand = [];
        array_push($brand, strval($targetProduct->brand_id));
        $request['cate_id'] = strval($targetProduct->cate_id);
        $request['brand_id'] = $brand;
        $request['top_selling'] = '';
        $result = $this->getAllProducts($request)->take(4);
        return $result;
    }
    public function checkAmount($amount, $id)
    {
        $product =  Product::find($id);
        if ($amount > $product->amount) {
            return false;
        } else {
            return true;
        }
    }
}
