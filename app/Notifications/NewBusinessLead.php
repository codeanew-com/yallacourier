<?php

namespace App\Notifications;

use App\Models\FormModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Tells staff a business lead came in. Queued, so the visitor's form submits
 * without waiting for the mail server; the scheduler's queue worker sends it
 * (routes/console.php). Reply-To is the lead, so staff can just hit Reply.
 */
class NewBusinessLead extends Notification implements ShouldQueue
{
    use Queueable;

    /** Retries if the mail server is temporarily unavailable. */
    public int $tries = 3;

    public array $backoff = [60, 300];

    public function __construct(public FormModel $lead) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $l = $this->lead;

        return (new MailMessage)
            ->subject('New business lead: '.($l->company_name ?: $l->fullName()))
            ->replyTo($l->email, $l->fullName())
            ->greeting('New business enquiry')
            ->line('**Name:** '.$l->fullName())
            ->line('**Company:** '.$l->company_name)
            ->line('**Position:** '.$l->position)
            ->line('**Email:** '.$l->email)
            ->line('**Phone:** '.$l->phone)
            ->line('**Parcels:** '.$l->number_of_parcel)
            ->line('**Current delivery partner:** '.$l->current_delivery_partner)
            ->line('**Received:** '.$l->created_at?->timezone('Asia/Dubai')->format('d M Y, H:i').' (Dubai)')
            ->action('Open in admin', route('admin.businessleads.show', $l->id))
            ->line('Reply to this email to answer '.$l->first_name.' directly.');
    }
}
