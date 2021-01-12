<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrawlProduct extends Model
{
    use HasFactory;

    protected $table = 'crawler_products';
    protected $fillable = [
        'name',
        'price',
        'brand',
        'category',
    ];
    //FILTER FUNCTIONS
    public function scopeBrand($query, $request)
    {
        if ($request->has('brand')) {
            $query->where('brand', $request->input('brand'));
        }
        return $query;
    }
    public function scopeCategory($query, $request)
    {
        if ($request->has('category')) {
            $query->where('category', $request->input('category'));
        }
        return $query;
    }
}
