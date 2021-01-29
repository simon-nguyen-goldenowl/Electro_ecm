<?php

namespace App\Http\Controllers;

use App\Enums\ResultType;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use App\Services\UserService;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class AuthController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function register()
    {
        return view('Pages.Register');
    }
    public function authenticate(Request $request)
    {
        $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return $user;
        } else {
            return ResultType::Failure;
        }
    }
    public function customerLogin(Request $request)
    {
        $user = $this->authenticate($request);
        if ($user === ResultType::Failure) {
            return ResultType::Failure;
        } else {
            session()->put('user', $user->id);
            return ResultType::Success;
        }
    }
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            session()->put('google_user', $user->id);
            return redirect('/')->with('message', 'login successfully');
        } catch (\Exception $e) {
            return redirect('/')->with('message', 'Something went wrong or You have rejected the app!');
        }

//            $finduser = User::where('google_id', $user->id)->first();
//
//            if ($finduser) {
//                Auth::login($finduser);
//
//                return redirect()->intended('dashboard');
//            } else {
//                $newUser = User::create([
//                    'name' => $user->name,
//                    'email' => $user->email,
//                    'google_id' => $user->id,
//                    'password' => encrypt('123456dummy')
//                ]);
//
//                Auth::login($newUser);
//
//                return redirect()->intended('dashboard');
//            }
    }
    public function userLogin(Request $request) //apply JWT to authenticate
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $jwt = $this->generateToken($user);
            return response()->json([
                'token' => $jwt
            ]);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }
    protected function generateToken($user)
    {
        $key = config('jwt.secret_key');
        $payload = [
            "exp" => Carbon::now()->addDays(1)->timestamp,  // Maximum expiration time is one hour
            "uid" => $user->id,
        ];
        return JWT::encode($payload, $key) ;
    }
    public function adminLogin(Request $request)
    {
        $user = $this->authenticate($request);
        if ($user === ResultType::Failure) {
            return response()->json(ResultType::Failure);
        } else {
            if ($user->is_admin === 1) {
                $data = [
                    'id' => $user->id,
                    'token' => Hash::make($user->name)
                ];
                return response()->json($data);
            } else {
                return response()->json(ResultType::Failure);
            }
        }
    }
    public function logout()
    {
        session()->flush();
        return redirect('/');
    }
    public function adminLogout()
    {
        Auth::logout();
    }
    public function checkMail(Request $request)
    {
        $message = $this->userService->checkMail($request->input());
        return back()->with('message', $message);
    }
    public function resetPassword(ResetPasswordRequest $request, $id)
    {
        $data = $this->userService->resetPassword($id, $request->input());
        return $data;
    }
    public function changePassword(ChangePasswordRequest $request)
    {
        $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials)) {
            $id = session()->get('user')->id;
            $data = $this->userService->update($id, $request->input());
        } else {
            $data = false;
        }
        return response()->json($data);
    }
}
