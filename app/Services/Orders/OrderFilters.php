<?php

namespace App\Services\Orders;

use App\Models\OrderMetaModel;
use App\Models\OrderModel;
use App\Models\OrderPackagesModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * The admin orders list filters (tabs, search box, finance filters). Also used
 * by "settle all filtered orders", so both always select the same orders.
 */
class OrderFilters
{
    /** Meta keys the free-text search looks through. */
    private const SEARCH_META_KEYS = ['sender_name', 'sender_phone', 'sender_email', 'reciever_name', 'reciever_phone', 'reciever_email'];

    /**
     * Normalised filter values; anything unrecognised becomes '' (no filter).
     *
     * @return array{q: string, status: string, payment: string, courier: string, settled: string, s_date: string, e_date: string}
     */
    public static function fromRequest(Request $request): array
    {
        return [
            'q' => trim((string) $request->input('q', '')),
            'status' => in_array($request->input('status'), OrderModel::STATUSES, true) ? $request->input('status') : '',
            'payment' => in_array($request->input('payment'), ['paid', 'unpaid'], true) ? $request->input('payment') : '',
            'courier' => (string) $request->input('courier', ''),
            'settled' => in_array($request->input('settled'), ['yes', 'no'], true) ? $request->input('settled') : '',
            's_date' => preg_match('/^\d{4}-\d{2}-\d{2}$/', (string) $request->input('s_date')) ? $request->input('s_date') : '',
            'e_date' => preg_match('/^\d{4}-\d{2}-\d{2}$/', (string) $request->input('e_date')) ? $request->input('e_date') : '',
        ];
    }

    public static function query(array $f): Builder
    {
        $query = OrderModel::query();

        if ($f['status'] !== '') {
            $query->where('status', $f['status']);
        }
        if ($f['payment'] === 'paid') {
            $query->where('payment_status', 1);
        } elseif ($f['payment'] === 'unpaid') {
            $query->where('payment_status', '<>', 1);
        }
        if ($f['courier'] === 'unassigned') {
            $query->where('courier', 0);
        } elseif (ctype_digit($f['courier']) && $f['courier'] !== '0') {
            $query->where('courier', (int) $f['courier']);
        }
        if ($f['settled'] === 'yes') {
            $query->where('order_settled', '>', 0);
        } elseif ($f['settled'] === 'no') {
            $query->where('order_settled', 0);
        }
        // Same date semantics as the old search page: one date = that single day,
        // both dates = inclusive range.
        if ($f['s_date'] !== '' && $f['e_date'] !== '') {
            $query->whereBetween('created_at', [$f['s_date'].' 00:00:00', $f['e_date'].' 23:59:59']);
        } elseif ($f['s_date'] !== '') {
            $query->whereDate('created_at', $f['s_date']);
        } elseif ($f['e_date'] !== '') {
            $query->whereDate('created_at', $f['e_date']);
        }

        if ($f['q'] !== '') {
            $q = ltrim($f['q'], '#');
            $like = '%'.str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $q).'%';
            $query->where(function (Builder $w) use ($q, $like) {
                if (ctype_digit($q)) {
                    $w->orWhere('id', (int) $q);
                }
                $w->orWhereIn('id', OrderMetaModel::select('order_id')->whereIn('key', self::SEARCH_META_KEYS)->where('value', 'like', $like))
                    ->orWhereIn('id', OrderPackagesModel::select('order_id')->where('awb_number', 'like', $like));
            });
        }

        return $query;
    }
}
