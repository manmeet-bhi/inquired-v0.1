<?php

namespace App\Notifications;

use App\Notifications\Channels\OneSignalChannel;
use App\Notifications\Messages\OneSignalMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OneSignalTestNotification extends Notification
{
    use Queueable;

    public string $title;
    public string $message;
    public ?string $url;
    public string $channelType; // 'push' or 'email'

    public function __construct(string $title, string $message, ?string $url = null, string $channelType = 'push')
    {
        $this->title = $title;
        $this->message = $message;
        $this->url = $url;
        $this->channelType = $channelType;
    }

    public function via(mixed $notifiable): array
    {
        return [OneSignalChannel::class];
    }

    public function toOneSignal(mixed $notifiable): OneSignalMessage
    {
        $msg = OneSignalMessage::create($this->message)
            ->title($this->title)
            ->url($this->url ?: url('/'));

        if ($this->channelType === 'email') {
            $msg->toEmail()
                ->emailSubject($this->title)
                ->emailBody("<p>{$this->message}</p>");
        } else {
            $msg->toPush();
        }

        return $msg;
    }
}
