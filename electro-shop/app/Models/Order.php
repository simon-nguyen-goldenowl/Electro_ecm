<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'orders';
    protected $fillable = [
        'code',
        'customer_id',
        'address',
        'phone',
        'email',
        'name',
        'order_status',
        'payment_status',
        'shipping_status',
        'note',
    ];
    public function orderDetail()
    {
        return $this->hasMany(OrderDetail::class);
    }
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
    public function orderStatus()
    {
        return $this->belongsTo(Status::class, 'order_status');
    }
    public function paymentStatus()
    {
        return $this->belongsTo(Status::class, 'payment_status');
    }
    public function shippingStatus()
    {
        return $this->belongsTo(Status::class, 'shipping_status');
    }
    public function scopeCustomerName($query, $request)
    {
        if ($request->has('customer_name')) {
            $name = $request->input('customer_name');
            $query->where('name', 'like', '%' . $name . '%');
        }
        return $query;
    }
    public function scopeAddress($query, $request)
    {
        if ($request->has('address')) {
            $address = $request->input('address');
            $query->where('address', 'like', '%' . $address . '%');
        }
        return $query;
    }
    public function scopePhone($query, $request)
    {
        if ($request->has('phone')) {
            $phone = $request->input('phone');
            $query->where('phone', 'like', '%' . $phone . '%');
        }
        return $query;
    }
    public function scopeEmail($query, $request)
    {
        if ($request->has('email')) {
            $email = $request->input('email');
            $query->where('email', 'like', '%' . $email . '%');
        }
        return $query;
    }
    public function scopeGuest($query, $request)
    {
        if ($request->has('type') && $request->get('type') == 'guest') {
            $query->where('customer_id', null);
        }
        return $query;
    }
    public function scopeMember($query, $request)
    {
        if ($request->has('type') && $request->get('type') == 'member') {
            $query->where('customer_id', '!=', null);
        }
        return $query;
    }
    public function scopeOrderStatus($query, $request)
    {
        if ($request->has('order_status')) {
            $query->where('order_status', $request->input('order_status'));
        }
        return $query;
    }
    public function scopeShippingStatus($query, $request)
    {
        if ($request->has('shipping_status')) {
            $query->where('shipping_status', $request->input('shipping_status'));
        }
        return $query;
    }
    public function scopePaymentStatus($query, $request)
    {
        if ($request->has('payment_status')) {
            $query->where('payment_status', $request->input('payment_status'));
        }
        return $query;
    }
}
