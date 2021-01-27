<?php

namespace App\Services;

use App\Enums\ESStatusType;
use App\Enums\OrderStatusType;
use App\Enums\PaymentStatusType;
use App\Enums\ShippingStatusType;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderService extends CommonService
{
    public function getModel()
    {
        return Order::class;
    }
    public function getAllOrders(Request $request)
    {
        $query = $this->filterColumn($request);
        $result = $this->getAll($query, $request);
        return $result;
    }
    protected function filterColumn(Request $request)
    {
        $query = Order::with('paymentStatus')
                         ->with('orderStatus')
                         ->with('shippingStatus')
                         ->customerName($request)
                         ->address($request)
                         ->phone($request)
                         ->email($request)
                         ->member($request)
                         ->orderStatus($request)
                         ->shippingStatus($request)
                         ->paymentStatus($request)
                         ->guest($request);
        return $query;
    }
    public function showOrder()
    {
        $customer_id = session()->get('user');
        $data = Order::with('paymentStatus')
                       ->with('orderStatus')
                       ->with('shippingStatus')
                       ->where('customer_id', $customer_id)->get();
        return $data;
    }
    public function showOrderDetail($id)
    {
        $detail = OrderDetail::with('product')->where('order_id', $id)->get();
        return $detail;
    }
    public function create($request)
    {
        if (session()->has('user')) {
            $request['customer_id'] = session()->get('user');
        }
        $request['code'] = $this->generateOrdercode($request);
        $request['order_status'] = OrderStatusType::OrderSuccess;
        $request['shipping_status'] = ShippingStatusType::Shipping;
        $request['payment_status'] = PaymentStatusType::Pending;
        $request['created_date'] = Carbon::now();
        return parent::create($request);
    }
    public function findOrderByProduct($id)
    {
        $detail = OrderDetail::select('order_id')->where('product_id', $id)->get();
        return $detail;
    }
    public function generateOrdercode($request)
    {
        if (!isset($request['code'])) {
            $id = Order::select('id')->max('id') + 1;
            $result = strval($id);
            $code = 'O' . str_pad($result, 4, 0, STR_PAD_LEFT);
            return $code;
        }
    }
    public function addItem($id)
    {
        $request['order_id'] = $id;
        $cartItems = session()->get('cart_items');
        foreach ($cartItems as $item => $val) {
            $request['product_id'] = $item;
            $request['price'] = $val['price'];
            $request['amount'] = $val['amount'];
            $request['total'] = $val['price'] * $val['amount'];
            OrderDetail::query()->create($request);
            $this->subAmount($item, $val['amount']);
        }
    }
    public function subAmount($id, $amount)
    {
        $product = Product::find($id);
        $amount = $product->amount - $amount;
        $product->amount = $amount;
        $product->es_status = ESStatusType::IsUpdated;
        $product->save();
    }
}
