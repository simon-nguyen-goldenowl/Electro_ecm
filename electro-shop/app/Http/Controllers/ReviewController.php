<?php

namespace App\Http\Controllers;

use App\Enums\DefaultType;
use App\Services\ReviewService;
use http\Env\Response;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $reviewService;
    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }
    public function index(Request $request)
    {
        $data = $this->reviewService->getAllReviews($request);
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->reviewService->create($request->input());
        return back()->with('message', 'Your review is submitted');
    }

    /**
     * Display the specified resource.
     *@param  \Illuminate\Http\Request  $request
     * @param  int  $product_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $product_id)
    {
        $data = $this->reviewService->getReview($product_id)->paginate($request['limit']);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $data = $this->reviewService->delete($id);
        return response()->json($data);
    }
}
