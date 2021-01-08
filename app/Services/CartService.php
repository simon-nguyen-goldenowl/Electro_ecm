<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;

class CartService
{
    protected $cart = [];
    protected $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
        //initialize session key 'cart_items' with value = cart []
        session()->put('cart_items', $this->cart);
        session()->put('totalItems', 0);
        session()->put('totalPrices', 0);
    }
    public function addCart($id)
    {
        //get the value of key 'cart_items' to process
        $this->cart = session()->get('cart_items');
        //check if value is exist in cart array
        if (isset($this->cart[$id])) {
            $this->cart[$id]['amount']++;
        } else {
            $product = $this->productService->getById($id);
            $cart_item = [
                'name' => $product->name,
                'category' => $product->category->name,
                'brand' => $product->brand->name,
                'price' => $product->price,
                'image' => $product->image,
                'amount' => 1

            ];
            $this->cart[$id] = $cart_item;
        }
        session()->put('cart_items', $this->cart);
        $this->calculatePrice();
        $this->calculateItem();
    }
    public function checkCart()
    {
        $this->cart = session()->get('cart_items');
        foreach ($this->cart as $key => $value) {
            if (!Product::find($key)) {
                $this->deleteItem($key);
            }
        }
    }
    public function showCart(Request $request)
    {
        return $request->session()->all();
    }
    public function calculatePrice()
    {
        $total = 0;
        $items = session()->get('cart_items');
        foreach ($items as $item) {
            $total = $total + ($item['price'] * $item['amount']);
        }
        session()->put('totalPrices', $total);
    }
    public function calculateItem()
    {
        $total = 0;
        $items = session()->get('cart_items');
        foreach ($items as $item) {
            $total = $total + $item['amount'];
        }
        session()->put('totalItems', $total);
    }
    public function updateCart(Request $request, $id)
    {
        $this->cart = session()->get('cart_items');
        $this->cart[$id]['amount'] = $request['amount'];
        session()->put('cart_items', $this->cart);
        $this->calculatePrice();
        $this->calculateItem();
    }

    public function deleteItem($id)
    {
        $this->cart = session()->get('cart_items');
        unset($this->cart[$id]);
        session()->put('cart_items', $this->cart);
        $this->calculatePrice();
        $this->calculateItem();
    }
    public function deleteCart()
    {
        session()->put('cart_items', []);
        session()->put('totalPrices', 0);
        session()->put('totalItems', 0);
    }
}
