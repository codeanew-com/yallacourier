<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\AdminLoginCode;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

/** Staff login: password, then a 6-digit code emailed to the admin. */
class AdminLoginOtpTest extends TestCase
{
    use DatabaseTransactions;

    private function admin(): User
    {
        return User::create(['name' => 'Admin', 'email' => 'a_'.uniqid().'@example.com', 'password' => 'Secret12345']);
    }

    /** Password step; returns the emailed code. */
    private function passwordStep(User $admin, array $extra = []): string
    {
        $this->post('/login', ['email' => $admin->email, 'password' => 'Secret12345'] + $extra)->assertRedirect(route('login.otp'));

        $code = null;
        Notification::assertSentTo($admin, AdminLoginCode::class, function ($n) use (&$code) {
            $code = $n->code;

            return true;
        });

        return $code;
    }

    public function test_correct_password_alone_does_not_sign_in_and_emails_a_code(): void
    {
        Notification::fake();
        $admin = $this->admin();

        $code = $this->passwordStep($admin);

        $this->assertMatchesRegularExpression('/^\d{6}$/', $code);
        $this->assertGuest('web');
        $this->get('/admin')->assertRedirect('/login');
        $this->get(route('login.otp'))->assertOk()->assertSee($admin->email);
    }

    public function test_correct_code_signs_in_and_goes_to_admin(): void
    {
        Notification::fake();
        $admin = $this->admin();
        $code = $this->passwordStep($admin);

        $this->post(route('login.otp.verify'), ['code' => $code])->assertRedirect('/admin');
        $this->assertAuthenticatedAs($admin, 'web');
        $this->get('/admin')->assertOk();

        // The code is single-use.
        $this->post('/logout');
        $this->post(route('login.otp.verify'), ['code' => $code])->assertRedirect(route('login'));
        $this->assertGuest('web');
    }

    public function test_wrong_password_sends_no_code(): void
    {
        Notification::fake();
        $admin = $this->admin();

        $this->from('/login')->post('/login', ['email' => $admin->email, 'password' => 'wrong'])
            ->assertRedirect('/login')->assertSessionHasErrors('email');
        Notification::assertNothingSent();
        $this->get(route('login.otp'))->assertRedirect(route('login'));
    }

    public function test_wrong_codes_are_limited(): void
    {
        Notification::fake();
        $admin = $this->admin();
        $code = $this->passwordStep($admin);
        $wrong = $code === '000000' ? '111111' : '000000';

        for ($i = 1; $i <= 4; $i++) {
            $this->from(route('login.otp'))->post(route('login.otp.verify'), ['code' => $wrong])
                ->assertRedirect(route('login.otp'))->assertSessionHasErrors('code');
        }
        // 5th wrong code ends the attempt; even the right code no longer works.
        $this->post(route('login.otp.verify'), ['code' => $wrong])->assertRedirect(route('login'))->assertSessionHasErrors('email');
        $this->post(route('login.otp.verify'), ['code' => $code])->assertRedirect(route('login'));
        $this->assertGuest('web');
    }

    public function test_code_expires(): void
    {
        Notification::fake();
        $admin = $this->admin();
        $code = $this->passwordStep($admin);

        $this->travel(11)->minutes();
        $this->post(route('login.otp.verify'), ['code' => $code])->assertRedirect(route('login'))->assertSessionHasErrors('email');
        $this->assertGuest('web');
    }

    public function test_resend_waits_a_minute_and_replaces_the_code(): void
    {
        Notification::fake();
        $admin = $this->admin();
        $first = $this->passwordStep($admin);

        $this->from(route('login.otp'))->post(route('login.otp.resend'))->assertSessionHas('otp_error');
        Notification::assertSentToTimes($admin, AdminLoginCode::class, 1);

        $this->travel(61)->seconds();
        $this->from(route('login.otp'))->post(route('login.otp.resend'))->assertSessionHas('status');
        Notification::assertSentToTimes($admin, AdminLoginCode::class, 2);

        $second = null;
        Notification::assertSentTo($admin, AdminLoginCode::class, function ($n) use (&$second) {
            $second = $n->code;

            return true;
        });
        if ($first !== $second) {
            $this->post(route('login.otp.verify'), ['code' => $first])->assertSessionHasErrors('code');
        }
        $this->post(route('login.otp.verify'), ['code' => $second])->assertRedirect('/admin');
        $this->assertAuthenticatedAs($admin, 'web');
    }

    public function test_remember_me_is_applied_after_the_code(): void
    {
        Notification::fake();
        $admin = $this->admin();
        $code = $this->passwordStep($admin, ['remember' => 'on']);

        $this->post(route('login.otp.verify'), ['code' => $code])->assertRedirect('/admin')
            ->assertCookie(auth()->guard('web')->getRecallerName());
    }

    public function test_switch_off_restores_password_only_login(): void
    {
        config(['auth.admin_otp.enabled' => false]);
        Notification::fake();
        $admin = $this->admin();

        $this->post('/login', ['email' => $admin->email, 'password' => 'Secret12345'])->assertRedirect('/admin');
        $this->assertAuthenticatedAs($admin, 'web');
        Notification::assertNothingSent();
    }
}
