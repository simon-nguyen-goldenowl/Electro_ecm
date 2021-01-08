<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'reviews';
    protected $fillable = [
        'product_id',
        'customer_id',
        'content'
    ];
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
    public function scopeProduct($query, $request)
    {
        if ($request->has('product_id')) {
            $query->where('product_id', $request->input('product_id'));
        }
    }
}
