<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Services\NotificationService;
use App\Services\UserService;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $userService;
    protected $notiService;
    public function __construct(UserService $userService, NotificationService $notiService)
    {
        $this->userService = $userService;
        $this->notiService = $notiService;
    }
    public function index(Request $request)
    {
        $data = $this->userService->getAllUser($request);
        return response()->json($data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Validation\Validator  $validator
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserCreateRequest $request)
    {
        $data = $this->userService->create($request->input());
        return response()->json($data);
    }

    public function showAllNoti()
    {
        return $this->notiService->getNotifications();
    }
    public function readNoti()
    {
        return $this->notiService->readNotifications();
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $data = $this->userService->getById($id);
        return response()->json($data);
    }

    public function getProfile(Request $request)
    {
        $payload = JWT::decode($request->header('Authorization'), config('jwt.secret_key'), array('HS256'));
        $user = $this->userService->getById($payload->uid);
        return response()->json($user);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $data = $this->userService->update($id, $request->input());
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
