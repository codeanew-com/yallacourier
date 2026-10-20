<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * A business lead from the website's business sign-up form.
 *
 * State lives in two nullable timestamps (see the 2026_10_20 migration):
 *   unread   = read_at IS NULL      (set the first time an admin opens the lead)
 *   archived = archived_at IS NOT NULL
 * The scopes below are the only definitions of "inbox" / "unread" / "archived",
 * used by the table, its tabs and the sidebar badge alike.
 */
class FormModel extends Model
{
    protected $table = 'form';

    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'position',
        'company_name',
        'number_of_parcel',
        // 'reason_for_switching_provider',
        'current_delivery_partner',
    ];

    protected function casts(): array
    {
        return [
            'read_at' => 'datetime',
            'archived_at' => 'datetime',
        ];
    }

    public function scopeInbox(Builder $q): Builder
    {
        return $q->whereNull('archived_at');
    }

    public function scopeArchived(Builder $q): Builder
    {
        return $q->whereNotNull('archived_at');
    }

    /** Unread leads in the inbox — exactly what the sidebar badge counts. */
    public function scopeUnread(Builder $q): Builder
    {
        return $q->whereNull('archived_at')->whereNull('read_at');
    }

    public function isUnread(): bool
    {
        return $this->read_at === null;
    }

    public function fullName(): string
    {
        return trim($this->first_name.' '.$this->last_name);
    }

    /** One-line summary used as the lead's "subject" in lists. */
    public function subject(): string
    {
        $parts = array_filter([
            $this->company_name,
            $this->number_of_parcel !== null && $this->number_of_parcel !== '' ? $this->number_of_parcel.' parcels' : null,
        ]);

        return $parts ? implode(' · ', $parts) : 'Business enquiry';
    }
}
