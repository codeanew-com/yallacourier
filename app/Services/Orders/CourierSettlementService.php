<?php

namespace App\Services\Orders;

use App\Models\OrderModel;
use App\Services\ActivityLogger;

/**
 * Marks what we owe couriers for orders as paid.
 * Courier payable = courier_quote + courier_vat (see OrderPricing).
 */
class CourierSettlementService
{
    public function __construct(private ActivityLogger $activity) {}

    /**
     * @param  array<int, int|string>  $ids
     * @return array{0: int, 1: float} [orders settled, amount settled]
     */
    public function settle(array $ids): array
    {
        $count = 0;
        $amount = 0.0;
        foreach (OrderModel::whereIn('id', $ids)->where('order_settled', 0)->where('status', '<>', 'cancelled')->get() as $order) {
            $payable = (float) $order->courier_quote + (float) $order->courier_vat;
            if ($payable <= 0) {
                // Nothing to pay the courier yet (e.g. unpriced pending order) —
                // settling it would just hide it from the outstanding list.
                continue;
            }
            $order->order_settled = $payable;
            $order->save();
            $count++;
            $amount += $payable;
        }

        if ($count > 0) {
            $this->activity->record('Courier payment settled for '.$count.' order(s), AED '.number_format($amount, 2).' (orders: '.implode(', ', array_slice($ids, 0, 50)).(count($ids) > 50 ? ', …' : '').')');
        }

        return [$count, $amount];
    }
}
