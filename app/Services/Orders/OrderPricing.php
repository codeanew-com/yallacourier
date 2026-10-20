<?php

namespace App\Services\Orders;

use App\Models\CourierModel;

/**
 * Single source of truth for order money maths in the admin panel.
 *
 * The rules here were derived from the 373 priced orders created by the old
 * courier-API booking flow (removed 2026-10-19), and are what the stored data
 * actually follows:
 *
 *   total          = round(subtotal + vat + service_fee, 2)      (372/373 orders)
 *   courier_quote  = subtotal                                     (373/373 orders)
 *   commission     = subtotal * p / (100 + p)                     p = courier's configured %
 *                    i.e. subtotal is the courier's base cost marked up by p%,
 *                    and commission is the markup part of it.
 *   courier payable (settlement) = courier_quote + courier_vat    (CourierSettlementService)
 *   profit         = commission + service_fee + over_head         (orders dashboard)
 *
 * VAT and courier VAT followed different, courier-specific API rules, so they
 * are never derived automatically — the admin enters them (the UI offers
 * one-click 5% helpers). The frontend mirrors this file in
 * resources/views/admin/order/partials/pricing-script.blade.php; this class
 * stays authoritative because OrderUpdater recomputes on save.
 */
class OrderPricing
{
    /** UAE VAT rate, as already assumed by the finance stats on the orders page. */
    public const VAT_RATE = 5;

    /** Values an order's sender/receiver country can hold when it means the UAE. */
    private const UAE_VALUES = ['', 'are', 'ae', 'uae', 'united arab emirates'];

    public static function isUae(?string $country): bool
    {
        return in_array(strtolower(trim((string) $country)), self::UAE_VALUES, true);
    }

    public static function isInternational(?string $senderCountry, ?string $recieverCountry): bool
    {
        return ! self::isUae($senderCountry) || ! self::isUae($recieverCountry);
    }

    public static function total(float $subtotal, float $vat, float $serviceFee): float
    {
        return round($subtotal + $vat + $serviceFee, 2);
    }

    public static function commissionRate(CourierModel $courier, bool $international, bool $document): float
    {
        if ($international) {
            return (float) ($document ? $courier->comission_document_intl : $courier->comission_intl);
        }

        return (float) ($document ? $courier->comission_document : $courier->comission);
    }

    public static function commission(float $subtotal, float $ratePercent): float
    {
        if ($subtotal <= 0 || $ratePercent <= 0) {
            return 0.0;
        }

        return round($subtotal * $ratePercent / (100 + $ratePercent), 2);
    }

    public static function serviceFee(CourierModel $courier, bool $international): float
    {
        return (float) ($international ? $courier->service_fee_intl : $courier->service_fee);
    }

    public static function courierPayable(float $courierQuote, float $courierVat): float
    {
        return round($courierQuote + $courierVat, 2);
    }

    public static function profit(float $commission, float $serviceFee, float $overHead): float
    {
        return round($commission + $serviceFee + $overHead, 2);
    }

    /**
     * Per-courier settings the order screen needs to pre-fill and recalculate
     * live, keyed by courier id. Kept here so the JS never hardcodes rates.
     */
    public static function courierRates(iterable $couriers): array
    {
        $rates = [];
        foreach ($couriers as $c) {
            $rates[$c->id] = [
                'name' => $c->name,
                'comission' => (float) $c->comission,
                'comission_document' => (float) $c->comission_document,
                'comission_intl' => (float) $c->comission_intl,
                'comission_document_intl' => (float) $c->comission_document_intl,
                'service_fee' => (float) $c->service_fee,
                'service_fee_intl' => (float) $c->service_fee_intl,
            ];
        }

        return $rates;
    }
}
