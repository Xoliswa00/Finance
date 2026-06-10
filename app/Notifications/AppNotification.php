<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class AppNotification extends Notification
{
    public function __construct(
        private string $title,
        private string $message,
        private string $icon = 'info',
        private ?string $link = null
    ) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'title'   => $this->title,
            'message' => $this->message,
            'icon'    => $this->icon,
            'link'    => $this->link,
        ];
    }
}
