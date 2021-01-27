<?php

namespace App\Console\Crobjob;

use App\Enums\ESIndexType;
use App\Enums\ESStatusType;
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
        $products = Product::where('es_status', ESStatusType::IsNotSynced)
            ->with('brand')
            ->with('category')
            ->with('orderDetail')
            ->with('review')
            ->take(100)->get();
        foreach ($products as $product) {
            $params = [
                'index' => ESIndexType::ProductIndex,
                'id' => $product->id,
                'body' => [
                    'name' => $product->name,
                    'price' => $product->price,
                    'amount' => $product->amount,
                    'image' => $product->image,
                    'cate_id' => $product->cate_id,
                    'brand_id' => $product->brand_id,
                    'cate_name' => $product->category->name,
                    'brand_name' => $product->brand->name,
                    'review' => $product->review->count(),
                    'selling' => $product->orderDetail->sum('amount')
                ]
            ];
            $this->client->index($params);
            $product->es_status = ESStatusType::IsSynced;
            $product->save();
        }
    }

    public function indexCategoryDocument()
    {
        $categories = Category::where('es_status', ESStatusType::IsNotSynced)->take(15)->get();
        foreach ($categories as $cate) {
            $params = [
                'index' => ESIndexType::CategoryIndex,
                'id' => $cate->id,
                'body' => [
                    'name' => $cate->name,
                ]
            ];
            $this->client->index($params);
            $cate->es_status = ESStatusType::IsSynced;
            $cate->save();
        }
    }

    public function indexBrandDocument()
    {
        $brands = Brand::where('es_status', ESStatusType::IsNotSynced)->take(15)->get();
        foreach ($brands as $brand) {
            $params = [
                'index' => ESIndexType::BrandIndex,
                'id' => $brand->id,
                'body' => [
                    'name' => $brand->name,
                ]
            ];
            $this->client->index($params);
            $brand->es_status = ESStatusType::IsSynced;
            $brand->save();
        }
    }

    public function syncUpdatedProduct()
    {
        //This function is used to sync data between database and elastic search after update record
        $products = Product::where('es_status', ESStatusType::IsUpdated)
            ->with('brand')
            ->with('category')
            ->with('orderDetail')
            ->with('review')
            ->take(100)->get();
        foreach ($products as $product) {
            $params = [
                'index' => ESIndexType::ProductIndex,
                'id' => $product->id,
                'body' => [
                    'doc' => [
                        'name' => $product->name,
                        'price' => $product->price,
                        'amount' => $product->amount,
                        'image' => $product->image,
                        'cate_id' => $product->cate_id,
                        'brand_id' => $product->brand_id,
                        'cate_name' => $product->category->name,
                        'brand_name' => $product->brand->name,
                        'review' => $product->review->count(),
                        'selling' => $product->orderDetail->sum('amount')
                    ]
                ]
            ];
            $this->client->update($params);
            $product->es_status = ESStatusType::IsSynced;
            $product->save();
        }
    }
    public function syncUpdatedCategory()
    {
        $categories = Category::where('es_status', ESStatusType::IsUpdated)->take(15)->get();
        foreach ($categories as $cate) {
            $params = [
                'index' => ESIndexType::CategoryIndex,
                'id' => $cate->id,
                'body' => [
                    'doc' => [
                        'name' => $cate->name,
                    ]
                ]
            ];
            $this->client->update($params);
            $cate->es_status = ESStatusType::IsSynced;
            $cate->save();
        }
    }
    public function syncUpdatedBrand()
    {
        $brands = Brand::where('es_status', ESStatusType::IsUpdated)->take(15)->get();
        foreach ($brands as $brand) {
            $params = [
                'index' => ESIndexType::BrandIndex,
                'id' => $brand->id,
                'body' => [
                    'doc' => [
                        'name' => $brand->name,
                    ]
                ]
            ];
            $this->client->update($params);
            $brand->es_status = ESStatusType::IsSynced;
            $brand->save();
        }
    }
    public function syncDeletedProduct()
    {
        $products = Product::onlyTrashed()->take(100)->get();
        foreach ($products as $product) {
            $params = [
                'index' => ESIndexType::ProductIndex,
                'id'    => $product->id
            ];
            $this->client->delete($params);
        }
    }
    public function syncDeletedCategory()
    {
        $categories = Category::onlyTrashed();
        foreach ($categories as $cate) {
            $params = [
                'index' => ESIndexType::CategoryIndex,
                'id'    => $cate->id
            ];
            $this->client->delete($params);
        }
    }
    public function syncDeletedBrand()
    {
        $brands = Brand::onlyTrashed();
        foreach ($brands as $brand) {
            $params = [
                'index' => ESIndexType::BrandIndex,
                'id'    => $brand->id
            ];
            $this->client->delete($params);
        }
    }
}
