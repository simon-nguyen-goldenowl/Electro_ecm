<?php

namespace App\Services;

use App\Enums\DefaultType;
use App\Enums\ESIndexType;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use wataridori\SFS\SimpleFuzzySearch;
use Elasticsearch\ClientBuilder;

class SearchService
{
    protected $client;
    public function __construct()
    {
        $this->client = ClientBuilder::create()->build();
    }
    public function syncDataAfterUpdate($id, $request, $index)
    {
        //This function is used to sync data between database and elastic search after update record
        switch ($index) {
            case ESIndexType::ProductIndex:
                $cate_name = Category::find($request['cate_id'])->name;
                $brand_name = Brand::find($request['brand_id'])->name;
                $params = [
                    'index' => $index,
                    'id'    => $id,
                    'body'  => [
                        'doc' => [
                            'name' => $request['name'],
                            'price' => $request['price'],
                            'cate_id' => $request['cate_id'],
                            'brand_id' => $request['brand_id'],
                            'cate_name' => $cate_name,
                            'brand_name' => $brand_name
                        ]
                    ]
                ];
                $this->client->update($params);
                break;
            case ESIndexType::CategoryIndex:
            case ESIndexType::BrandIndex:
                $params = [
                'index' => $index,
                'id'    => $id,
                'body'  => [
                    'doc' => [
                        'name' => $request['name'],
                    ]
                ]
                ];
                $this->client->update($params);
                break;
        }
    }
    public function syncDataAfterDelete($index, $id)
    {
        //This function is used to sync data between database and elastic search after delete record
        $params = [
            'index' => $index,
            'id'    => $id
        ];
        $this->client->delete($params);
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
