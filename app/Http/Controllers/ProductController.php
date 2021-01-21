<?php

namespace App\Http\Controllers;

use App\Enums\ESIndexType;
use App\Enums\ResultType;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Services\CartService;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\ReviewService;
use App\Services\SearchService;
use App\Services\WishlistService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;
    protected $reviewService;
    protected $orderService;
    protected $wishlistService;
    protected $cartService;
    protected $searchService;
    public function __construct(
        ProductService $productService,
        ReviewService $reviewService,
        OrderService $orderService,
        WishlistService $wishlistService,
        CartService $cartService,
        SearchService $searchService
    ) {
        $this->productService = $productService;
        $this->reviewService = $reviewService;
        $this->orderService = $orderService;
        $this->wishlistService = $wishlistService;
        $this->cartService = $cartService;
        $this->searchService = $searchService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $data = $this->productService->getAllProducts($request);
        return response()->json($data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param ProductCreateRequest $request
     * @return JsonResponse
     */
    public function store(ProductCreateRequest $request)
    {
        $data = $this->productService->create($request->input());
        return response()->json($data);
    }
    /**
     * Display the specified resource.
     *@param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $data = $this->productService->getById($id);
        return response()->json($data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ProductUpdateRequest $request, $id)
    {
        $data = $this->productService->update($id, $request->input());
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        //check related order, if existed cannot delete
        $order = $this->orderService->findOrderByProduct($id);
        if (count($order) > 0) {
            return response()->json(ResultType::Failure);
        }
        //call function to delete related reviews, wishlist
        $this->deleteRelated($id);
        //delete product
        $this->productService->delete($id);
        $this->searchService->syncDataAfterDelete(ESIndexType::ProductIndex, $id);
        return response()->json(ResultType::Success);
    }
    private function deleteRelated($id)
    {
        //delete related review
        $this->reviewService->deleteReviews($id);
        //delete related wishlist
        $this->wishlistService->deleteWishlist($id);
        //delete related cart
    }
}
