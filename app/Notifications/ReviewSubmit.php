<?php

namespace App\Notifications;

use App\Models\Review;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\OneSignal\OneSignalChannel;
use NotificationChannels\OneSignal\OneSignalMessage;
use NotificationChannels\PusherPushNotifications\PusherChannel;
use NotificationChannels\PusherPushNotifications\PusherMessage;

class ReviewSubmit extends Notification
{
    use Queueable;

    protected $review;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Review $review)
    {
        $this->review = $review;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [OneSignalChannel::class];
    }
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array|OneSignalMessage|PusherMessage
     */
    public function toPushNotification()
    {
        return OneSignalMessage::create()
            ->setSubject("Your review was submitted!")
            ->setBody("Click here to see details.")
            ->setUrl('http://onesignal.com');
    }
}
