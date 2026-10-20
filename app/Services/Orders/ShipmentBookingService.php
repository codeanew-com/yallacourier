<?php

namespace App\Services\Orders;

use App\Models\OrderDimensionModel;
use App\Models\OrderMetaModel;
use App\Models\OrderModel;
use App\Services\ActivityLogger;

/**
 * Direct shipment booking from the public site (2026-10-19) — replaces the old
 * "compare couriers, pick one, pay" flow. The request becomes a pending,
 * unpriced order with no courier; an admin reviews it, assigns a courier and
 * moves it forward. No courier API call and no payment happen here.
 */
class ShipmentBookingService
{
    public function __construct(private OrderMailService $mailer, private ActivityLogger $activity) {}

    /**
     * @param  array<string, mixed>  $input  the booking form fields
     * @param  int  $customerId  the logged-in customer, or 0 for a guest booking
     */
    public function book(array $input, int $customerId): OrderModel
    {
        $order = $this->createOrder($customerId);
        $this->saveMeta($order, $input);
        $this->saveDimensions($order, $input);
        $this->sendConfirmations($order);

        return $order;
    }

    private function createOrder(int $customerId): OrderModel
    {
        $order = new OrderModel;
        $order->customer_id = $customerId;
        $order->vat = 0;
        $order->total = 0;
        $order->subtotal = 0;
        $order->courier_quote = 0;
        $order->comission = 0;
        $order->over_head = 0;
        $order->service_fee = 0;
        $order->courier_vat = 0;
        $order->payment_status = 0;
        $order->status = 'pending';
        $order->courier = 0;
        $order->save();

        return $order;
    }

    private function saveMeta(OrderModel $order, array $in): void
    {
        $isIntl = filled($in['shipment_from_country'] ?? null) || filled($in['shipment_to_country'] ?? null);

        $meta = [
            'sender_name' => $in['sender_name'] ?? null,
            'sender_phone' => $in['sender_phone'] ?? null,
            'sender_email' => $in['sender_email'] ?? null,
            'sender_country' => $isIntl ? ($in['shipment_from_country'] ?? null) : 'United Arab Emirates',
            'sender_state' => $in['shipment_from'] ?? null,
            'sender_city' => $in['shipment_from_city_map'] ?? $in['shipment_from_city_map1'] ?? null,
            'sender_area' => $in['shipment_from_1'] ?? $in['shipment_from_2'] ?? null,
            'sender_address' => trim(($in['shipment_from_1'] ?? $in['shipment_from_2'] ?? '').' '.($in['shipment_from_city_map'] ?? $in['shipment_from_city_map1'] ?? '')),

            'reciever_name' => $in['reciever_name'] ?? null,
            'reciever_phone' => $in['reciever_phone'] ?? null,
            'reciever_email' => $in['reciever_email'] ?? null,
            'reciever_country' => $isIntl ? ($in['shipment_to_country'] ?? null) : 'United Arab Emirates',
            'reciever_state' => $in['shipment_to'] ?? null,
            'reciever_city' => $in['shipment_to_city_map'] ?? null,
            'reciever_area' => $in['searchdeladd'] ?? $in['shipment_to_1'] ?? null,
            'searchdeladd' => trim(($in['searchdeladd'] ?? $in['shipment_to_1'] ?? '').' '.($in['shipment_to_city_map'] ?? '')),

            'box_contents' => $in['document_type'] ?? 'Parcel',
            'declared_value' => $in['declared_value'] ?? 0,

            // Single-value summary (first package) for pages that display one row —
            // the full per-package breakdown is saved to order_dimensions.
            'shipment_qty' => $in['shipment_qty'][0] ?? null,
            'shipment_length' => $in['shipment_length'][0] ?? null,
            'shipment_width' => $in['shipment_width'][0] ?? null,
            'shipment_height' => $in['shipment_height'][0] ?? null,
            'shipment_weight' => $in['shipment_weight'][0] ?? null,
        ];

        foreach ($meta as $key => $value) {
            if ($value === null || $value === '') {
                continue;
            }
            $m = new OrderMetaModel;
            $m->order_id = $order->id;
            $m->key = $key;
            $m->value = $value;
            $m->save();
        }
    }

    private function saveDimensions(OrderModel $order, array $in): void
    {
        foreach ($in['shipment_qty'] as $key => $qty) {
            $d = new OrderDimensionModel;
            $d->order_id = $order->id;
            $d->qty = $qty;
            $d->width = $in['shipment_width'][$key] ?? 0;
            $d->length = $in['shipment_length'][$key] ?? 0;
            $d->height = $in['shipment_height'][$key] ?? 0;
            $d->weight = $in['shipment_weight'][$key] ?? 0;
            $d->save();
        }
    }

    /**
     * The invoice follows later from the admin ("Resend emails") once the order
     * is priced. A mail failure must never lose the booking: it is logged and
     * shown on the order timeline.
     */
    private function sendConfirmations(OrderModel $order): void
    {
        $sent = $this->mailer->sendBookingConfirmations($order);

        $this->activity->record(
            'Order #'.$order->id.': booking confirmation email '.collect($sent)->map(fn ($ok, $who) => $who.' '.($ok ? 'sent' : 'FAILED (see laravel.log)'))->implode(', '),
            0
        );
    }
}
