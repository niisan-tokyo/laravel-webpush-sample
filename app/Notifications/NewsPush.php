<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class NewsPush extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [WebPushChannel::class];
    }

    /**
     * プッシュ通知をする
     *
     * @param [type] $notifiable
     * @param [type] $notification
     * @return void
     */
    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('新着情報')
            ->icon('/favicon.ico')
            ->body('test news incomming!!')
            ->action('View news', 'view_news');
    }
}
