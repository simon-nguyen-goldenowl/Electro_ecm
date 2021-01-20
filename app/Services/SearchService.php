<?php

namespace App\Services;

use App\Enums\DefaultType;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use wataridori\SFS\SimpleFuzzySearch;
use Elasticsearch\ClientBuilder;

class SearchService
{
    protected $client;


    public function indexDocument()
    {
        $param = [
            'index' => 'my_index',
            'id'    => 'my_id',
            'body'  => ['testField' => 'abc']
        ];
    }
    public function showSuggestList(Request $request)
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
    public function getSearchProducts(Request $request)
    {
        $key = $request['q'];
        $products = Product::query()
                            ->selectRaw('products.*, brands.name as brand, categories.name as cate')
                            ->join('brands', 'brands.id', 'products.brand_id')
                            ->join('categories', 'categories.id', 'products.cate_id')
                            ->get();
        $data = [];
        foreach ($products as $product) {
            array_push($data, $product);
        }
        $fuzzy = new SimpleFuzzySearch($data, ['name', 'brand' , 'cate']);
        $results = $fuzzy->search($key);
        return $results;
    }
    public function proccessSearchList(Request $request, $searchList, $totalProduct)
    {
        $perPage = $request['limit'];
        $page = $request['page'];
        $searchCollection = collect();
        foreach ($searchList as $item) {
            $searchCollection->push($item[0]);
        }
        if (isset($request['min_price'])) {
            $searchCollection = $searchCollection->filter(function ($value, $key) use ($request) {
                return $request['max_price'] > $value->price && $value->price > $request['min_price'];
            });
        }
        return $searchCollection->forPage($page, $perPage);
    }
    public function generatePaginate(Request $request, $totalProduct)
    {
        $perPage = DefaultType::default_limit;
        $page = 1;
        if (isset($request['limit'])) {
            $perPage = $request['limit'];
        }
        if (isset($request['page'])) {
            $page = $request['page'];
        }
        $totalPage = strval(ceil($totalProduct / $perPage));
        $paginateCollection = collect([
            'currentPage' => $page,
            'perPage' => $perPage,
            'lastPage' => $totalPage
        ]);
        return $paginateCollection;
    }
}
