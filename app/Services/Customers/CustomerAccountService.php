<?php

namespace App\Services\Customers;

use App\Models\CustomerModel;
use App\Notifications\CustomerPasswordLink;
use App\Services\ActivityLogger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

/**
 * Admin-side customer account management. Accounts are only ever created
 * here (public registration is closed), and the admin never chooses or sees a
 * customer's own password: either the customer gets an emailed link to set
 * one, or a random temporary password is shown once and must be changed at
 * first login.
 *
 * Every change is written to the activity log as "Customer #<id>: …", which
 * the customer profile's Activity tab reads back.
 */
class CustomerAccountService
{
    /** Fields an admin may edit, with their log label. Password, remember token and wallet balance are deliberately excluded. */
    public const EDITABLE = ['name' => 'name', 'email' => 'email', 'phone' => 'phone', 'company_name' => 'company', 'designation' => 'designation'];

    public function __construct(private CustomerSessionRevoker $revoker, private ActivityLogger $activity) {}

    /**
     * @param  array{name: string, email: string, phone?: ?string, company_name?: ?string, designation?: ?string, account_status: string, onboarding: string}  $data
     * @return array{0: CustomerModel, 1: ?string} the new account and, for the "temporary" onboarding, its temporary password
     */
    public function create(array $data): array
    {
        $temporary = $data['onboarding'] === 'temporary' ? $this->generatePassword() : null;
        $active = $data['account_status'] === CustomerModel::ACTIVE;

        $c = new CustomerModel;
        $c->forceFill([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'company_name' => $data['company_name'] ?? null,
            'designation' => $data['designation'] ?? null,
            // Invite: an unguessable random password nobody knows until the customer sets their own.
            'password' => $temporary ?? Str::password(40),
            'must_change_password' => $temporary !== null,
            'balance' => 0,
            'account_status' => $data['account_status'],
            'status_changed_at' => $active ? null : now(),
            'status_changed_by' => $active ? null : Auth::id(),
            'status_reason' => $active ? null : 'Created as disabled by an admin',
            'created_by' => Auth::id(),
        ])->save();

        $this->log($c, 'account created ('.$c->account_status.', '.($temporary ? 'temporary password issued' : 'password setup link emailed').')');

        return [$c, $temporary];
    }

    /**
     * Email a one-time link: 'setup' (first password for an invited account)
     * or 'reset'.
     *
     * @return array{0: bool, 1: string} [sent?, message for the admin]
     */
    public function sendPasswordLink(CustomerModel $c, string $purpose): array
    {
        $broker = Password::broker($purpose === 'setup' ? 'customer_setup' : 'customers');
        try {
            $status = $broker->sendResetLink(['email' => $c->email], function ($customer, $token) use ($purpose) {
                $customer->notify(new CustomerPasswordLink($token, $purpose));
            });
        } catch (\Throwable $e) {
            report($e);

            return [false, 'The email to '.$c->email.' could not be sent ('.class_basename($e).'). Check the mail settings, then use "Send password reset link" on the profile.'];
        }

        return match ($status) {
            Password::RESET_LINK_SENT => [true, ($purpose === 'setup' ? 'A link to set their password' : 'A password reset link').' was emailed to '.$c->email.'.'],
            Password::RESET_THROTTLED => [false, 'A link was emailed to '.$c->email.' less than a minute ago. Wait a minute before sending another.'],
            default => [false, 'The link could not be sent to '.$c->email.'.'],
        };
    }

    /**
     * Admin "Send password reset link". An invited customer who never set a
     * password gets the longer-lived setup link instead.
     *
     * @return array{0: bool, 1: string}
     */
    public function sendResetOrSetupLink(CustomerModel $c): array
    {
        $neverSetPassword = $c->password_changed_at === null && $c->created_by !== null && ! $c->must_change_password;
        [$ok, $msg] = $this->sendPasswordLink($c, $neverSetPassword ? 'setup' : 'reset');
        if ($ok) {
            $this->log($c, 'password reset link emailed to '.$c->email);
        }

        return [$ok, $msg];
    }

    /** Replace the password with a temporary one (returned) and end every session. */
    public function issueTemporaryPassword(CustomerModel $c): string
    {
        $temporary = $this->generatePassword();
        $c->forceFill(['password' => $temporary, 'must_change_password' => true])->save();
        $ended = $this->revoker->revoke($c); // the old password no longer works anywhere
        $this->log($c, 'temporary password issued; must be changed at next login; '.$ended.' active session(s) ended');

        return $temporary;
    }

    /**
     * Apply the edited profile fields.
     *
     * @param  array<string, mixed>  $input
     * @return array<int, string> human-readable changes; empty when nothing changed (nothing is saved then)
     */
    public function updateProfile(CustomerModel $c, array $input): array
    {
        $changes = [];
        foreach (self::EDITABLE as $field => $label) {
            $new = $input[$field] ?? null;
            $new = $new === '' ? null : $new;
            if ((string) $c->$field !== (string) $new) {
                // Contact details are logged with old → new values; nothing secret is stored on this table's editable fields.
                $changes[] = $label.' "'.($c->$field ?? '').'" → "'.($new ?? '').'"';
                $c->$field = $new;
            }
        }
        if (! $changes) {
            return [];
        }
        if (in_array('email', array_keys($c->getDirty()), true)) {
            $c->email_verified_at = null; // a changed address hasn't been verified
        }

        $c->save();
        $this->log($c, 'profile edited: '.implode('; ', $changes));

        return $changes;
    }

    /**
     * Suspend / ban / disable / reactivate. Blocking also ends every active session.
     *
     * @return int sessions ended
     */
    public function changeStatus(CustomerModel $c, string $action, ?string $reason, mixed $suspendedUntil): int
    {
        $before = $c->effectiveStatus();
        $newStatus = match ($action) {
            'suspend' => CustomerModel::SUSPENDED,
            'ban' => CustomerModel::BANNED,
            'disable' => CustomerModel::DISABLED,
            'reactivate' => CustomerModel::ACTIVE,
        };

        $c->account_status = $newStatus;
        $c->status_reason = $action === 'reactivate' ? null : $reason;
        $c->suspended_until = $action === 'suspend' ? $suspendedUntil : null;
        $c->status_changed_at = now();
        $c->status_changed_by = Auth::id();
        $c->save();

        $ended = $newStatus !== CustomerModel::ACTIVE ? $this->revoker->revoke($c) : 0;

        $this->log($c, 'account status '.$before.' → '.$newStatus
            .($c->status_reason ? '; reason: '.$c->status_reason : '')
            .($c->suspended_until ? '; until '.$c->suspended_until->format('d M Y H:i') : '')
            .($newStatus !== CustomerModel::ACTIVE ? '; '.$ended.' active session(s) ended' : ''));

        return $ended;
    }

    /** "Sign out of all devices". @return int sessions ended */
    public function revokeSessions(CustomerModel $c): int
    {
        $ended = $this->revoker->revoke($c);
        $this->log($c, 'signed out of all devices ('.$ended.' active session(s) ended)');

        return $ended;
    }

    /** 14 chars, mixed case, digits, no ambiguous characters (0/O, 1/l/I) so it can be read out. */
    public function generatePassword(): string
    {
        $sets = ['ABCDEFGHJKLMNPQRSTUVWXYZ', 'abcdefghijkmnpqrstuvwxyz', '23456789'];
        $all = implode('', $sets);
        $chars = array_map(fn ($s) => $s[random_int(0, strlen($s) - 1)], $sets);
        while (count($chars) < 14) {
            $chars[] = $all[random_int(0, strlen($all) - 1)];
        }
        shuffle($chars);

        return implode('', $chars);
    }

    private function log(CustomerModel $c, string $what): void
    {
        $this->activity->record('Customer #'.$c->id.': '.$what);
    }
}
