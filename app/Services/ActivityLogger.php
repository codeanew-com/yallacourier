<?php

namespace App\Services;

use App\Models\LogModel;
use Illuminate\Support\Facades\Auth;

/**
 * Writes the admin activity trail (`log_admin` table).
 *
 * Entries are plain sentences; screens find their own entries by prefix
 * ("Order #12: …", "Customer #7: …"), so keep those prefixes stable.
 */
class ActivityLogger
{
    /**
     * @param  int|null  $by  Who did it. Defaults to the logged-in admin, or 0 for the system/public site.
     */
    public function record(string $message, ?int $by = null): LogModel
    {
        $log = new LogModel;
        $log->mess = $message;
        $log->added_by = $by ?? Auth::id() ?? 0;
        $log->save();

        return $log;
    }
}
