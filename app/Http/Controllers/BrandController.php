<?php

namespace App\Http\Controllers;

use App\Enums\ESIndexType;
use App\Enums\ResultType;
use App\Http\Requests\BrandCreateRequest;
use App\Http\Requests\BrandUpdateRequest;
use App\Services\BrandService;
use App\Services\ProductService;
use App\Services\SearchService;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    protected $brandService;
    protected $productService;
    protected $searchService;
    public function __construct(
        BrandService $brandService,
        ProductService $productService,
        SearchService $searchService
    ) {
        $this->brandService = $brandService;
        $this->productService = $productService;
        $this->searchService = $searchService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $data = $this->brandService->getAllBrands($request);
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\BrandCreateRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(BrandCreateRequest $request)
    {
        $data = $this->brandService->create($request->input());
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
        $data = $this->brandService->getById($id);
        return response()->json($data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(BrandUpdateRequest $request, $id)
    {
        $data = $this->brandService->update($id, $request->input());
        $this->searchService->syncDataAfterUpdate($id, $request->input(), ESIndexType::BrandIndex);
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id, Request $request)
    {
        $request['brand'] = $id;
        $product = $this->productService->getAllProducts($request);
        if ($product->total() > 0) {
            return response()->json(ResultType::Failure);
        }
        $this->brandService->delete($id);
        $this->searchService->syncDataAfterDelete(ESIndexType::BrandIndex, $id);
        return response()->json(ResultType::Success);
    }
}
