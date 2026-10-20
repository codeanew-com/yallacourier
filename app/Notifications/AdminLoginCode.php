<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/** The one-time code for the second step of the staff (admin) login. */
class AdminLoginCode extends Notification
{
    public function __construct(public string $code, public int $minutes) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Yalla Courier admin sign-in code: '.$this->code)
            ->greeting('Hello '.$notifiable->name.',')
            ->line('Use this code to finish signing in to the Yalla Courier admin panel:')
            ->line('**'.$this->code.'**')
            ->line('It expires in '.$this->minutes.' minutes and can be used once.')
            ->line('If you didn’t just try to sign in, someone may know your password: change it straight away.');
    }
}
