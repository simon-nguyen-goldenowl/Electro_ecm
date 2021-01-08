<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'statuses';
    protected $fillable = [
        'name',
        'type'
    ];
    public function scopeOrderStatus($query, $request)
    {
        if ($request->has('order_status')) {
            $query->where('type', 'O');
        }
    }
    public function scopeShippingStatus($query, $request)
    {
        if ($request->has('shipping_status')) {
            $query->where('type', 'S');
        }
    }
    public function scopePaymentStatus($query, $request)
    {
        if ($request->has('payment_status')) {
            $query->where('type', 'P');
        }
    }
}
