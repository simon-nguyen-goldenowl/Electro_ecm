<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Services\CartService;
use App\Services\OrderService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    protected $orderService;
    protected $cartService;
    protected $productService;
    public function __construct(OrderService $orderService, CartService $cartService, ProductService $productService)
    {
        $this->orderService = $orderService;
        $this->cartService = $cartService;
        $this->productService = $productService;
    }
    //FUNCTIONS RETURN LARAVEL BLADE VIEW
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
        DB::transaction(function () use ($request) {
            $result = $this->orderService->create($request->input());
            $this->orderService->addItem($result->id);
            $this->cartService->deleteCart();
            return $result;
        });
    }
    //FUNCTIONS RETURN API
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $data = $this->orderService->getAllOrders($request);
        return response()->json($data);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $data = $this->orderService->showOrderDetail($id);
        return response()->json($data);
    }
}
