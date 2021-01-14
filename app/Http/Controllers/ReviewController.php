<?php

namespace App\Http\Controllers;

use App\Enums\DefaultType;
use App\Models\User;
use App\Notifications\ReviewSubmit;
use App\Services\NotificationService;
use App\Services\ReviewService;
use App\Services\UserService;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $reviewService;
    protected $userService;
    protected $notiService;
    public function __construct(
        ReviewService $reviewService,
        UserService $userService,
        NotificationService $notiService
    ) {
        $this->reviewService = $reviewService;
        $this->userService = $userService;
        $this->notiService = $notiService;
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
    public function submitReview(Request $request)
    {
         $payload = JWT::decode($request->header('Authorization'), config('jwt.secret_key'), array('HS256'));
         $request['customer_id'] = $payload->uid;
         $review = $this->reviewService->create($request->input());
         $user = $this->userService->getById($payload->uid);
         $reviewNoti = new ReviewSubmit($review);
         return $this->notiService->sendNotifications($reviewNoti);
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
