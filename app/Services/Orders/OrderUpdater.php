<?php

namespace App\Services\Orders;

use App\Models\CourierModel;
use App\Models\OrderDimensionModel;
use App\Models\OrderMetaModel;
use App\Models\OrderModel;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;

/**
 * Applies the admin order screen's form to an order: addresses/contents
 * (order_meta), pricing (recomputed here, never trusted from the form),
 * packages (order_dimensions), and one activity-log line describing the change.
 */
class OrderUpdater
{
    /** Order meta fields the admin order form can edit. */
    public const META_KEYS = [
        'sender_name', 'sender_phone', 'sender_email', 'sender_country', 'sender_state',
        'sender_city', 'sender_area', 'sender_address', 'box_contents', 'declared_value',
        'reciever_name', 'reciever_phone', 'reciever_email', 'reciever_country', 'reciever_state',
        'reciever_city', 'reciever_area', 'searchdeladd', 'delivery_type',
    ];

    private const PRICE_FIELDS = ['status', 'payment_status', 'courier', 'subtotal', 'vat', 'total', 'courier_quote', 'courier_vat', 'comission', 'over_head', 'service_fee'];

    public function __construct(private ActivityLogger $activity) {}

    /** $request must already be validated (UpdateOrderRequest). */
    public function update(OrderModel $order, Request $request): OrderModel
    {
        $before = $order->only(self::PRICE_FIELDS);

        // Every meta value is saved first so international/domestic detection
        // below uses the countries as they are after this edit.
        $metaChanges = $this->saveMeta($order, $request);
        $this->applyPricing($order, $request);
        $order->save();

        $dimensionChanges = $this->saveDimensions($order, $request);

        $this->logChanges($order, $before, $metaChanges, $dimensionChanges);

        return $order;
    }

    /** @return array<int, string> the meta keys whose value changed */
    private function saveMeta(OrderModel $order, Request $request): array
    {
        $changed = [];
        foreach (self::META_KEYS as $key) {
            if (! $request->has($key)) {
                continue;
            }
            $meta = OrderMetaModel::where('order_id', $order->id)->where('key', $key)->first();
            if (! $meta) {
                $meta = new OrderMetaModel;
                $meta->order_id = $order->id;
                $meta->key = $key;
            }
            // A blank form field arrives here as null (Laravel's
            // ConvertEmptyStringsToNull middleware), but order_meta.value is
            // NOT NULL — coerce to '' so clearing a field doesn't crash.
            $value = $request->input($key) ?? '';
            if ((string) $meta->value !== (string) $value) {
                $changed[] = $key;
            }
            $meta->value = $value;
            $meta->save();
        }

        return $changed;
    }

    private function applyPricing(OrderModel $order, Request $request): void
    {
        $courier = $request->courier ? CourierModel::find($request->courier) : null;
        $subtotal = (float) $request->subtotal;
        $vat = (float) $request->vat;
        $serviceFee = (float) $request->service_fee;

        $order->status = $request->status;
        $order->payment_status = $request->payment_status;
        $order->courier = (int) $request->courier;
        $order->subtotal = $subtotal;
        $order->vat = $vat;
        $order->service_fee = $serviceFee;
        $order->over_head = (float) $request->over_head;
        $order->courier_vat = (float) $request->courier_vat;

        // The courier quote has always equalled the subtotal; it only differs
        // when the admin explicitly unticks "same as subtotal" and types one.
        $order->courier_quote = $request->boolean('quote_same_as_subtotal') || $request->courier_quote === null
            ? $subtotal
            : (float) $request->courier_quote;

        if ($request->input('commission_mode', 'manual') === 'auto' && $courier) {
            $isIntl = OrderPricing::isInternational($request->input('sender_country'), $request->input('reciever_country'));
            $rate = OrderPricing::commissionRate($courier, $isIntl, $request->input('commission_basis') === 'document');
            $order->comission = OrderPricing::commission($subtotal, $rate);
        } else {
            $order->comission = (float) ($request->comission ?? 0);
        }

        // Never trust a posted total — it is always derived here.
        $order->total = OrderPricing::total($subtotal, $vat, $serviceFee);
    }

    /** @return array<int, string> human-readable descriptions of changed packages */
    private function saveDimensions(OrderModel $order, Request $request): array
    {
        $changes = [];
        $fields = ['qty', 'length', 'width', 'height', 'weight'];
        foreach ((array) $request->input('dimension_id', []) as $i => $dimId) {
            // Scoped to this order so a tampered id can't edit another order's packages.
            $dim = OrderDimensionModel::where('order_id', $order->id)->where('id', $dimId)->first();
            if (! $dim) {
                continue;
            }
            $dirty = false;
            foreach ($fields as $f) {
                $value = (int) $request->input('dimension_'.$f.'.'.$i, $dim->$f);
                if ((int) $dim->$f !== $value) {
                    $dim->$f = $value;
                    $dirty = true;
                }
            }
            if ($dirty) {
                $dim->save();
                $changes[] = 'package '.($i + 1);
            }
        }

        return $changes;
    }

    private function logChanges(OrderModel $order, array $before, array $metaChanges, array $dimensionChanges): void
    {
        $labels = [
            'status' => 'status', 'payment_status' => 'payment', 'courier' => 'courier', 'subtotal' => 'subtotal',
            'vat' => 'VAT', 'total' => 'total', 'courier_quote' => 'courier quote', 'courier_vat' => 'courier VAT',
            'comission' => 'commission', 'over_head' => 'overhead', 'service_fee' => 'service fee',
        ];
        $couriers = CourierModel::pluck('name', 'id');
        $fmt = function ($field, $value) use ($couriers) {
            return match ($field) {
                'payment_status' => $value == 1 ? 'paid' : 'unpaid',
                'courier' => $value ? ($couriers[$value] ?? '#'.$value) : 'unassigned',
                'status' => (string) $value,
                default => number_format((float) $value, 2),
            };
        };

        $parts = [];
        foreach ($labels as $field => $label) {
            $old = $before[$field];
            $new = $order->$field;
            $changed = in_array($field, ['status', 'payment_status', 'courier'], true)
                ? (string) $old !== (string) $new
                : abs((float) $old - (float) $new) >= 0.005;
            if ($changed) {
                $parts[] = $label.' '.$fmt($field, $old).' → '.$fmt($field, $new);
            }
        }
        if ($metaChanges) {
            $parts[] = 'edited '.str_replace(['reciever', 'searchdeladd', '_'], ['receiver', 'receiver address', ' '], implode(', ', $metaChanges));
        }
        if ($dimensionChanges) {
            $parts[] = 'updated '.implode(', ', $dimensionChanges);
        }
        if (! $parts) {
            return;
        }

        $this->activity->record('Order #'.$order->id.': '.implode('; ', $parts));
    }
}
