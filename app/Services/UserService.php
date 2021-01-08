<?php

namespace App\Services;

use App\Mail\ResetPasswordMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserService extends CommonService
{

    public function getModel()
    {
        return User::class;
    }
    public function getAllUser(Request $request)
    {
        $query = $this->filterColumn($request);
        $result = $this->getAll($query, $request);
        return $result;
    }
    public function filterColumn(Request $request)
    {
        $query = User::query()->name($request)
                              ->address($request)
                              ->email($request)
                              ->phone($request)
                              ->code($request);
        return $query;
    }
    public function create($request)
    {
        $request['code'] = $this->generateUsercode($request);
        $request['password'] = Hash::make($request['password']);
        return parent::create($request);
    }
    public function generateUsercode($request)
    {
        if (!isset($request['code'])) {
            $id = User::select('id')->max('id') + 1;
            $result = strval($id);
            $code = 'U' . str_pad($result, 4, 0, STR_PAD_LEFT);
            return $code;
        }
    }
    public function update($id, $request)
    {
        if (isset($request['new_password'])) {
            $request['password'] = Hash::make($request['new_password']);
            unset($request['new_password']);
        }
        $user = parent::update($id, $request);
        if (session()->has('user')) {
            session()->put('user', $user);
        }
        return $user;
    }
    public function checkMail($request)
    {
        $email = $request['email'];
        $user = User::where('email', $email)->first();
        if ($user != null) {
            $key = $this->generateResetKey($user->id);
            Mail::to($request['email'])->send(new ResetPasswordMail($user, $key));
            session()->put('reset_time', Carbon::now());
            $message = 'We sent to your email the password reset link. Check it now';
        } else {
            $message = 'Cannot find this email. Try again';
        }
        return $message;
    }
    public function generateResetKey($id)
    {
        $key = Hash::make('user' . $id);
        $request['reset_key'] = $key;
        $request['reset_key_time'] = Carbon::now();
        $this->update($id, $request);
        return $key;
    }
    public function resetPassword($id, $request)
    {
        $user = User::find($id);
        $key = $user->reset_key;
        if ($request['reset_key'] === $key) {
            $user->password = Hash::make($request['password']);
            $user->reset_key = null;
            $user->reset_key_time = null;
            $user->save();
            session()->forget('reset_time');
            return $user;
        } else {
            $user->reset_key = null;
            $user->reset_key_time = null;
            $user->save();
            session()->forget('reset_time');
            return 419; //expired code
        }
    }
}
