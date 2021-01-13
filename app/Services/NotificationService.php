<?php

namespace App\Services;

use App\Models\Brand;
use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;

class NotificationService
{
    protected $user;

    public function __construct(Request $request)
    {
        $payload = JWT::decode($request->header('Authorization'), config('jwt.secret_key'), array('HS256'));
        $this->user = User::find($payload->uid);
    }
    public function getNotifications()
    {
        return $this->user->notifications;
    }
    public function readNotifications()
    {
        $unread = $this->user->unreadnotifications;
        $this->user->unreadNotifications->markAsRead();
        return $unread;
    }
}
