<?php

namespace App\Services\Customers;

use App\Models\CustomerModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Ends every logged-in session of one customer.
 *
 * Sessions use the database driver, but the `sessions.user_id` column only
 * tracks the default (admin) guard, so customer sessions are found through the
 * `login_customers_<hash>` key inside the payload. When sessions are encrypted
 * (SESSION_ENCRYPT=true) payloads can't be read here; the per-request
 * EnforceCustomerAccountStatus middleware still logs those sessions out on
 * their next request, so access is cut off either way.
 */
class CustomerSessionRevoker
{
    public function revoke(CustomerModel $customer): int
    {
        // Invalidate "remember me" cookies too.
        $customer->setRememberToken(Str::random(60));
        $customer->saveQuietly();

        if (config('session.driver') !== 'database' || config('session.encrypt')) {
            return 0;
        }

        $table = config('session.table', 'sessions');
        $loginKey = Auth::guard('customers')->getName(); // login_customers_<sha1>
        $ids = [];

        DB::table($table)->select('id', 'payload')->orderBy('id')->chunk(500, function ($rows) use ($customer, $loginKey, &$ids) {
            foreach ($rows as $row) {
                $data = @unserialize(base64_decode($row->payload), ['allowed_classes' => false]);
                if (is_array($data) && isset($data[$loginKey]) && (string) $data[$loginKey] === (string) $customer->getKey()) {
                    $ids[] = $row->id;
                }
            }
        });

        if ($ids) {
            DB::table($table)->whereIn('id', $ids)->delete();
        }

        return count($ids);
    }
}
