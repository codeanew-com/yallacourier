<?php

namespace App\Services\Orders;

use App\Models\CourierModel;
use App\Models\OrderMetaModel;
use App\Models\OrderModel;
use App\Models\OrderPackagesModel;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class OrderMailService
{
    /**
     * Send one order-related email (thank-you or invoice) to either the
     * sender or receiver side of an order, with the shipping label(s)
     * attached. $metaPrefix and $addressKey are passed explicitly by the
     * caller because the two places this logic previously lived did not
     * use identical OrderMetaModel keys for the address field — that
     * difference is preserved here, not unified.
     *
     * Sent through Laravel's mailer (2026-10-20), the same transport as every
     * other email: it honours MAIL_MAILER / MAIL_* and MAIL_FROM_ADDRESS.
     * Previously this class drove PHPMailer directly with a hardcoded sender,
     * notification@yallacourier.com, which the SMTP server rejects
     * ("553 5.7.1 Sender address rejected: not owned by user
     * no-reply@yallacourier.com"), so no order email was ever accepted.
     *
     * Returns false (and logs why) instead of throwing, so a mail problem never
     * breaks a booking or an admin action; callers report the result.
     */
    public function sendOrderEmail(OrderModel $order, string $metaPrefix, string $addressKey, string $subject, string $view): bool
    {
        $order_meta = OrderMetaModel::where('key', $metaPrefix.'_email')->where('order_id', $order->id)->first();
        if (! $order_meta || ! filter_var($order_meta->value, FILTER_VALIDATE_EMAIL)) {
            Log::warning('Order email skipped: no valid '.$metaPrefix.' email', ['order' => $order->id, 'subject' => $subject]);

            return false;
        }
        $name = OrderMetaModel::where('key', $metaPrefix.'_name')->where('order_id', $order->id)->first();
        $courier = CourierModel::find($order->courier);
        $addr = OrderMetaModel::where('key', $addressKey)->where('order_id', $order->id)->first();
        $state = OrderMetaModel::where('key', $metaPrefix.'_state')->where('order_id', $order->id)->first();
        $country = OrderMetaModel::where('key', $metaPrefix.'_country')->where('order_id', $order->id)->first();

        try {
            $body = view($view)
                ->with('name', $name->value ?? '')
                ->with('courier', $courier)
                ->with('order', $order)
                ->with('addr', $addr->value ?? '')
                ->with('state', $state->value ?? '')
                ->with('country', $country->value ?? '')
                ->render();

            $labels = OrderPackagesModel::where('order_id', $order->id)->get()
                ->filter(fn ($l) => $l->awb_label && Storage::disk('private')->exists($l->awb_label));

            $sent = Mail::send([], [], function (Message $m) use ($order_meta, $name, $subject, $body, $labels) {
                // From comes from MAIL_FROM_ADDRESS (config/mail.php "from"), which must be the
                // authenticated mailbox; the order emails no longer set their own sender.
                $m->to($order_meta->value, $name->value ?? null)
                    ->subject($subject)
                    ->html($body)
                    ->text(self::plainText($body));
                foreach ($labels as $label) {
                    $m->attach(Storage::disk('private')->path($label->awb_label));
                }
            });

            preg_match('/queued as (\S+)/', (string) $sent?->getDebug(), $q);
            Log::info('Order email sent', ['order' => $order->id, 'subject' => $subject, 'to' => $metaPrefix,
                'message_id' => $sent?->getMessageId(), 'smtp_queue_id' => $q[1] ?? null]);

            return true;
        } catch (\Throwable $e) {
            // Covers SMTP failures *and* template errors (which used to crash the request).
            // The exception message from the transport never contains the SMTP password.
            Log::error('Order email could not be sent', ['order' => $order->id, 'subject' => $subject, 'to' => $metaPrefix,
                'error' => class_basename($e).': '.$e->getMessage()]);

            return false;
        }
    }

    /**
     * Confirmation to both sides of a newly booked shipment.
     *
     * @return array{sender: bool, receiver: bool}
     */
    public function sendBookingConfirmations(OrderModel $order): array
    {
        return [
            'sender' => $this->sendOrderEmail($order, 'sender', 'sender_address', 'We received your shipment request #'.$order->id, 'mails.thankyou'),
            'receiver' => $this->sendOrderEmail($order, 'reciever', 'searchdeladd', 'A shipment is on its way to you #'.$order->id, 'mails.thankyou'),
        ];
    }

    /**
     * Admin "Resend emails": confirmation and invoice, to sender and receiver.
     *
     * @return array<int, bool> one result per email (4)
     */
    public function resendAll(OrderModel $order): array
    {
        return [
            $this->sendOrderEmail($order, 'sender', 'sender_address', 'Thankyou For Order', 'mails.thankyou'),
            $this->sendOrderEmail($order, 'reciever', 'searchdeladd', 'Thankyou For Order', 'mails.thankyou'),
            $this->sendOrderEmail($order, 'sender', 'sender_address', 'Order Invoice', 'mails.orderdetail'),
            $this->sendOrderEmail($order, 'reciever', 'searchdeladd', 'Order Invoice', 'mails.orderdetail'),
        ];
    }

    /** A real plain-text alternative (previously the raw HTML was repeated, which spam filters penalise). */
    private static function plainText(string $html): string
    {
        $html = preg_replace('#<(style|head|script)[^>]*>.*?</\1>#si', '', $html);
        $html = preg_replace('#<(br|/p|/tr|/h\d|/div)[^>]*>#i', "\n", $html);
        $text = html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = preg_replace("/[ \t]+/", ' ', $text);

        return trim(preg_replace("/\n\s*\n\s*\n+/", "\n\n", $text));
    }
}
