<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'wishlists';
    protected $fillable = [
        'customer_id',
        'product_id'
    ];
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
