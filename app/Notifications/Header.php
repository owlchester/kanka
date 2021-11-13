<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class Header extends Notification
{
    use Queueable;

    public $key;
    public $colour;
    public $icon;
    public $params;
    public $url;

    /**
     * Header constructor.
     * @param string $key
     * @param string $colour
     * @param string $icon
     * @param array $params
     */
    public function __construct($key = '', $icon = '', $colour = '', $params = [])
    {
        $this->key = $key;
        $this->colour = $colour;
        $this->icon = $icon;
        $this->params = $params;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }


    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'key' => $this->key,
            'colour' => $this->colour,
            'icon' => $this->icon,
            'params' => $this->params,
        ];
    }

    public function hasLink(): bool
    {
        dd($this);
    }
}
