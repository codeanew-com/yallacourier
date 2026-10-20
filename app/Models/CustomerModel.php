<?php

namespace App\Models;

use App\Notifications\CustomerPasswordLink;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class CustomerModel extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'customers';

    /**
     * Account states. Anything other than ACTIVE blocks login and ends existing
     * sessions (see App\Http\Middleware\EnforceCustomerAccountStatus).
     *   suspended — temporary, optionally until suspended_until
     *   banned    — permanent, for abuse/fraud
     *   disabled  — account switched off (e.g. at the customer's request)
     */
    public const ACTIVE = 'active';

    public const SUSPENDED = 'suspended';

    public const BANNED = 'banned';

    public const DISABLED = 'disabled';

    public const STATUSES = [self::ACTIVE, self::SUSPENDED, self::BANNED, self::DISABLED];

    /**
     * The attributes that are mass assignable.
     * (Status columns are deliberately not mass assignable — only the admin
     * access-control actions change them.)
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'company_name',
        'designation',
        'phone',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'suspended_until' => 'datetime',
            'status_changed_at' => 'datetime',
            'last_login_at' => 'datetime',
            'must_change_password' => 'boolean',
            'password_changed_at' => 'datetime',
        ];
    }

    /** Used by Laravel's password broker; sends our customer-specific link (not the admin reset URL). */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new CustomerPasswordLink($token, 'reset'));
    }

    /** The status that actually applies right now (an expired suspension counts as active). */
    public function effectiveStatus(): string
    {
        $status = $this->account_status ?: self::ACTIVE;
        if ($status === self::SUSPENDED && $this->suspended_until && $this->suspended_until->isPast()) {
            return self::ACTIVE;
        }

        return $status;
    }

    public function isBlocked(): bool
    {
        return $this->effectiveStatus() !== self::ACTIVE;
    }

    /** Message shown to the customer when they're refused access. */
    public function blockedMessage(): string
    {
        return match ($this->effectiveStatus()) {
            self::SUSPENDED => 'Your account is suspended'.($this->suspended_until ? ' until '.$this->suspended_until->format('d M Y, H:i') : '').'. Please contact Yalla Courier support.',
            self::BANNED => 'Your account has been banned. Please contact Yalla Courier support if you think this is a mistake.',
            self::DISABLED => 'Your account is disabled. Please contact Yalla Courier support to reactivate it.',
            default => '',
        };
    }

    /** Filter by effective status, treating expired suspensions as active. */
    public function scopeWithStatus(Builder $q, string $status): Builder
    {
        if ($status === self::ACTIVE) {
            return $q->where(function ($w) {
                $w->where('account_status', self::ACTIVE)->orWhereNull('account_status')
                    ->orWhere(fn ($s) => $s->where('account_status', self::SUSPENDED)->whereNotNull('suspended_until')->where('suspended_until', '<=', now()));
            });
        }
        if ($status === self::SUSPENDED) {
            return $q->where('account_status', self::SUSPENDED)
                ->where(fn ($s) => $s->whereNull('suspended_until')->orWhere('suspended_until', '>', now()));
        }

        return $q->where('account_status', $status);
    }
}
