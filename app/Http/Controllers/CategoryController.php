<?php

namespace App\Http\Controllers;

use App\Enums\ESIndexType;
use App\Enums\ESStatusType;
use App\Enums\ResultType;
use App\Http\Requests\CategoryCreateRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Services\CategoryService;
use App\Services\ProductService;
use App\Services\SearchService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;
    protected $productService;
    protected $searchService;
    public function __construct(
        CategoryService $categoryService,
        ProductService $productService,
        SearchService $searchService
    ) {
        $this->categoryService = $categoryService;
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
        $data = $this->categoryService->getAllCategories($request);
        return response()->json($data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CategoryCreateRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CategoryCreateRequest $request)
    {
        $data = $this->categoryService->create($request->input());
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
        $data = $this->categoryService->getById($id);
        return response()->json($data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CategoryUpdateRequest $request, $id)
    {
        $request['es_status'] = ESStatusType::IsUpdated;
        $data = $this->categoryService->update($id, $request->input());
        return response()->json($data);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        $request['cate_id'] = $id;
        $product = $this->productService->getAllProducts($request);
        if ($product->total() > 0) {
            return response()->json(ResultType::Failure);
        }
        $this->categoryService->delete($id);
        $this->searchService->syncDataAfterDelete(ESIndexType::CategoryIndex, $id);
        return response()->json(ResultType::Success);
    }
}
