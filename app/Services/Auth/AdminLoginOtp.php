<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Notifications\AdminLoginCode;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Hash;

/**
 * Second step of the staff login: a 6-digit code emailed to the admin.
 *
 * The pending login lives in the browser's session only (no table): which
 * admin passed the password check, a hash of the code (never the code
 * itself), when it expires, how many wrong tries were made and whether
 * "remember me" was ticked. Nobody is signed in until verify() succeeds.
 * Settings: config/auth.php "admin_otp".
 */
class AdminLoginOtp
{
    private const KEY = 'admin_login_otp';

    public function __construct(private Session $session) {}

    public static function enabled(): bool
    {
        return (bool) config('auth.admin_otp.enabled', true);
    }

    /** Begin the code step for an admin whose password was correct, and email the code. */
    public function start(User $user, bool $remember): bool
    {
        $this->session->put(self::KEY, ['user_id' => $user->getKey(), 'remember' => $remember]);

        return $this->send($user);
    }

    /** The admin waiting to enter a code, or null when there is no (valid) pending login. */
    public function pendingUser(): ?User
    {
        $id = $this->session->get(self::KEY.'.user_id');

        return $id ? User::find($id) : null;
    }

    /** Email a fresh code (replacing any earlier one). */
    public function send(User $user): bool
    {
        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $this->session->put(self::KEY.'.hash', Hash::make($code));
        $this->session->put(self::KEY.'.expires_at', now()->addMinutes((int) config('auth.admin_otp.expire', 10))->getTimestamp());
        $this->session->put(self::KEY.'.attempts', 0);
        $this->session->put(self::KEY.'.sent_at', now()->getTimestamp());

        try {
            $user->notify(new AdminLoginCode($code, (int) config('auth.admin_otp.expire', 10)));
        } catch (\Throwable $e) {
            report($e);

            return false;
        }

        return true;
    }

    /** Seconds until another code may be requested (0 = now). */
    public function resendWait(): int
    {
        $sentAt = (int) $this->session->get(self::KEY.'.sent_at', 0);

        return max(0, $sentAt + (int) config('auth.admin_otp.resend_after', 60) - now()->getTimestamp());
    }

    /**
     * Check a submitted code.
     *
     * @return array{0: string, 1: ?User, 2: bool} [result, user, remember] where result is
     *                                             'ok', 'invalid' (wrong code, try again), 'expired' or 'locked' (start over)
     */
    public function verify(string $code): array
    {
        $pending = $this->session->get(self::KEY);
        $user = $this->pendingUser();
        if (! $pending || ! $user || empty($pending['hash'])) {
            return ['expired', null, false];
        }

        if (now()->getTimestamp() > (int) $pending['expires_at']) {
            return ['expired', null, false];
        }

        if (! Hash::check($code, $pending['hash'])) {
            $attempts = (int) $pending['attempts'] + 1;
            if ($attempts >= (int) config('auth.admin_otp.max_attempts', 5)) {
                $this->clear();

                return ['locked', null, false];
            }
            $this->session->put(self::KEY.'.attempts', $attempts);

            return ['invalid', null, false];
        }

        $this->clear();

        return ['ok', $user, (bool) $pending['remember']];
    }

    public function attemptsLeft(): int
    {
        return max(0, (int) config('auth.admin_otp.max_attempts', 5) - (int) $this->session->get(self::KEY.'.attempts', 0));
    }

    public function clear(): void
    {
        $this->session->forget(self::KEY);
    }
}
