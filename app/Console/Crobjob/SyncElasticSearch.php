<?php

namespace App\Console\Crobjob;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Elasticsearch\ClientBuilder;

class SyncElasticSearch
{
    protected $client;
    public function __construct()
    {
        $this->client = ClientBuilder::create()->build();
    }
    public function indexProductDocument()
    {
        $products = Product::where('is_sync_es', 0)
                             ->with('brand')
                             ->with('category')
                             ->take(100)->get();
        foreach ($products as $product) {
            $params = [
                'index' => 'products',
                'id'    => $product->id,
                'body'  => [
                    'name' => $product->name,
                    'price' => $product->price,
                    'cate_id' => $product->cate_id,
                    'brand_id' => $product->brand_id,
                    'cate_name' => $product->category->name,
                    'brand_name' => $product->brand->name
                ]
            ];
            $this->client->index($params);
            $product->is_sync_es = 1;
            $product->save();
        }
    }
    public function indexCategoryDocument()
    {
        $categories = Category::where('is_sync_es', 0)->take(15)->get();
        foreach ($categories as $cate) {
            $params = [
                'index' => 'categories',
                'id'    => $cate->id,
                'body'  => [
                    'name' => $cate->name,
                ]
            ];
            $this->client->index($params);
            $cate->is_sync_es = 1;
            $cate->save();
        }
    }
    public function indexBrandDocument()
    {
        $brands = Brand::where('is_sync_es', 0)->take(15)->get();
        foreach ($brands as $brand) {
            $params = [
                'index' => 'brands',
                'id'    => $brand->id,
                'body'  => [
                    'name' => $brand->name,
                ]
            ];
            $this->client->index($params);
            $brand->is_sync_es = 1;
            $brand->save();
        }
    }
}
