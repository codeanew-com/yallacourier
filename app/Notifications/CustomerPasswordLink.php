<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Email with a one-time link for a customer to choose a password.
 *   reset — "forgot password" (self-service, or sent by an admin); expires per the `customers` broker
 *   setup — first password for an account an admin created; expires per `customer_setup`
 */
class CustomerPasswordLink extends Notification
{
    public function __construct(public string $token, public string $purpose = 'reset') {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $broker = $this->purpose === 'setup' ? 'customer_setup' : 'customers';
        $minutes = (int) config("auth.passwords.$broker.expire");
        $url = route('customer.password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
            'setup' => $this->purpose === 'setup' ? 1 : null,
        ]);
        $expires = $minutes >= 1440 ? intdiv($minutes, 1440).' days' : $minutes.' minutes';

        if ($this->purpose === 'setup') {
            return (new MailMessage)
                ->subject('Your Yalla Courier account is ready')
                ->greeting('Hello '.$notifiable->name.',')
                ->line('A Yalla Courier account has been created for you. Choose a password to start booking and tracking shipments.')
                ->action('Set my password', $url)
                ->line('This link expires in '.$expires.' and can be used once.')
                ->line('If you weren’t expecting this, you can ignore this email.');
        }

        return (new MailMessage)
            ->subject('Reset your Yalla Courier password')
            ->greeting('Hello '.$notifiable->name.',')
            ->line('We received a request to reset the password for your Yalla Courier account.')
            ->action('Reset password', $url)
            ->line('This link expires in '.$expires.' and can be used once.')
            ->line('If you didn’t ask for this, no action is needed: your password stays the same.');
    }
}
