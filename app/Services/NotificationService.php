<?php

namespace App\Services;

use App\Models\Brand;
use App\Models\User;
use App\Notifications;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;

class NotificationService
{
    protected $user;
    protected $notification;
    protected $namespace = 'App\\Notifications\\';
    public function __construct(Request $request, Notification $notification)
    {
        $payload = JWT::decode($request->header('Authorization'), config('jwt.secret_key'), array('HS256'));
        $this->user = User::find($payload->uid);
        $this->notification = $notification;
    }
    public function sendNotifications($notiType)
    {
        $this->user->notify($notiType);
        return 'ok';
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
