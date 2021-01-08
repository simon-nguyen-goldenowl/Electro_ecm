<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'products';
    protected $fillable = [
        'id',
        'code',
        'name',
        'cate_id',
        'brand_id',
        'image',
        'price',
        'amount',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'cate_id');
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
    public function review()
    {
        return $this->hasMany(Review::class);
    }
    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }
    public function orderDetail()
    {
        return $this->hasMany(OrderDetail::class);
    }
    //FILTER FUNCTIONS
    public function scopeCategory($query, $request)
    {
        if ($request->has('cate_id')) {
            $query->where('cate_id', $request->input('cate_id'));
        }
        return $query;
    }
    public function scopeBrandId($query, $request)
    {
        if ($request->has('brand')) {
            $query->where('brand_id', $request->input('brand'));
        }
        return $query;
    }
    public function scopeBrand($query, $request)
    {
        if ($request->has('brand_id')) {
            $query->whereIn('brand_id', $request['brand_id']);
        }
        return $query;
    }
    public function scopeNewest($query, $request)
    {
        if ($request->has('newest')) {
            $query->whereBetween('created_at', [Carbon::now()->subDays(15),Carbon::now()]);
        }
        return $query;
    }
    public function scopePrice($query, $request)
    {
        if ($request->has('min_price') || $request->has('max_price')) {
            $query->whereBetween('price', [$request->input('min_price'),$request->input('max_price')]);
        }
        return $query;
    }
    public function scopeAmount($query, $request)
    {
        if ($request->has('amount')) {
            $query->where('amount', $request->input('amount'));
        }
        return $query;
    }
    public function scopeTopselling($query, $request)
    {
        if ($request->has('top_selling')) {
            $query->leftjoin('order_details', 'products.id', '=', 'order_details.product_id')
                  ->selectRaw('products.id,products.name,products.cate_id,products.brand_id,
                  products.price,products.amount, products.image, sum(order_details.amount) total')
                  ->groupBy(
                      'products.id',
                      'products.name',
                      'products.cate_id',
                      'products.brand_id',
                      'products.image',
                      'products.price',
                      'products.amount'
                  )
                  ->orderBy('total', 'desc')->take(5);
        }
    }
    public function scopeName($query, $request)
    {
        if ($request->has('name')) {
            $name = $request->input('name');
            $query->where('name', 'like', '%' . $name . '%');
        }
        return $query;
    }
}
