<?php

namespace App\Notifications;

use App\Models\FormModel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Tells staff a business lead came in. Sent right after the visitor's response
 * (BusinessLeadNotifier), so it arrives immediately without slowing the form.
 * Reply-To is the lead, so staff can just hit Reply.
 */
class NewBusinessLead extends Notification
{
    use Queueable;

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
