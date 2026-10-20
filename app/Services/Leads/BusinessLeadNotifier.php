<?php

namespace App\Services\Leads;

use App\Models\FormModel;
use App\Models\Setting;
use App\Notifications\NewBusinessLead;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

/**
 * Emails staff about each new business lead, at the addresses an admin set
 * in Configuration → Notifications (setting business_lead_notification_emails).
 */
class BusinessLeadNotifier
{
    /** @return array<int, string> configured addresses; empty means notifications are off */
    public static function recipients(): array
    {
        return self::parse(Setting::get(Setting::BUSINESS_LEAD_EMAILS, ''));
    }

    /** Split a comma/semicolon/newline separated list into trimmed, unique addresses. */
    public static function parse(?string $value): array
    {
        $parts = preg_split('/[\s,;]+/', (string) $value, -1, PREG_SPLIT_NO_EMPTY);

        return array_values(array_unique(array_map('strtolower', $parts)));
    }

    /**
     * Send the email right after the visitor's response has gone out: staff get it
     * within seconds and the form doesn't wait for the mail server. No queue worker
     * or cron is involved. Never throws, because the lead is already saved.
     */
    public function notify(FormModel $lead): void
    {
        $to = self::recipients();
        if (! $to) {
            return;
        }

        dispatch(function () use ($lead, $to) {
            try {
                Notification::route('mail', $to)->notifyNow(new NewBusinessLead($lead));
            } catch (\Throwable $e) {
                Log::error('Business lead notification email failed', ['lead' => $lead->id, 'to' => $to, 'error' => class_basename($e).': '.$e->getMessage()]);
            }
        })->afterResponse();
    }
}
