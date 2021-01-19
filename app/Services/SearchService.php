<?php

namespace App\Services;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use wataridori\SFS\SimpleFuzzySearch;

class SearchService
{
    protected $brand_id;
    protected function autoComplete(Request $request)
    {
        if ($request->has('name')) {
            $productQuery = Product::query()->name($request);
            if ($request->input('cate_id') !== null) {
                $productQuery = $productQuery->where('cate_id', $request->input('cate_id'));
            }
            $product = $productQuery->take(5)->get();
            $brand = Brand::query()->name($request)->get();
            $data = [
                'brand' => $brand,
                'product' => $product,
            ];
            return $data;
        }
    }
    public function showSearchList(Request $request)
    {
        $data = $this->autoComplete($request);
        $output = '';
        if (count($data) > 0) {
            $output = '<ul class="list-group" style="display: block; position: relative; z-index: 1">';
            foreach ($data as $rows) {
                foreach ($rows as $row) {
                    $output .= '<li class="list-group-item"><a class="search-item" href="/search?q=' . $row->name . '">'
                        . $row->name .
                        '</a></li>';
                }
            }
            $output .= '</ul>';
        }
        return $output;
    }
    protected function checkIsBrand($search)
    {
        $brand = Brand::where('name', $search)->first();
        if ($brand !== null) {
            $this->brand_id = $brand->id;
            return true;
        }
        return false;
    }
    public function fuzzySearch(Request $request)
    {
        $brands = Brand::select('name', 'id')->get();
        $data = [];
        foreach ($brands as $brand) {
            array_push($data, $brand);
        }
        $fuzzy = new SimpleFuzzySearch($data, ['id', 'name']);
        $result = $fuzzy->search($request['search_name']);
        $name =  $result[0][0]->name;
    }
}
