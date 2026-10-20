<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** A setting admins can change in the panel (table `settings`, one row per key). */
class Setting extends Model
{
    /** Comma-separated addresses that receive an email for every new business lead. */
    public const BUSINESS_LEAD_EMAILS = 'business_lead_notification_emails';

    protected $fillable = ['key', 'value'];

    public static function get(string $key, ?string $default = null): ?string
    {
        return static::where('key', $key)->value('value') ?? $default;
    }

    public static function put(string $key, ?string $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}
