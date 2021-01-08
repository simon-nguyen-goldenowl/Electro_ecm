<?php

namespace App\Http\Controllers;

use App\Enums\ResultType;
use App\Services\CartService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;
    protected $productService;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(ProductService $productService, CartService $cartService)
    {
        $this->productService = $productService;
        $this->cartService = $cartService;
    }
    public function addCart($id)
    {
        if ($this->checkAmount($id) === ResultType::Failure) {
            return back()->with(['message' => 'This product do not have enough model']);
        }
        $this->cartService->addCart($id);
        return back()->with(['message' => 'This product is added to your cart']);
    }
    public function updateCart(Request $request, $id)
    {
        if ($this->checkAmount($id) === ResultType::Failure) {
            return ResultType::Failure;
        }
        $this->cartService->updateCart($request, $id);
        return session()->all();
    }
    public function deleteItem($id)
    {
        $this->cartService->deleteItem($id);
        return redirect('/carts');
    }
    private function checkAmount($id)
    {
        if (isset(session()->get('cart_items')[$id])) {
            $cart_amount = session()->get('cart_items')[$id]['amount'] + 1;
            if (!$this->productService->checkAmount($cart_amount, $id)) {
                return ResultType::Failure;
            } else {
                return ResultType::Success;
            }
        } else {
            return ResultType::Success;
        }
    }
}
