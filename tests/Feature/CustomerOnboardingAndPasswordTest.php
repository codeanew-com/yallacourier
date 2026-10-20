<?php

namespace Tests\Feature;

use App\Models\CustomerModel;
use App\Models\LogModel;
use App\Models\User;
use App\Notifications\CustomerPasswordLink;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class CustomerOnboardingAndPasswordTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        Notification::fake();
    }

    private function admin(): User
    {
        return User::create(['name' => 'Ops Admin', 'email' => 'a_'.uniqid().'@example.com', 'password' => bcrypt('x12345678')]);
    }

    private function customer(array $o = []): CustomerModel
    {
        $c = new CustomerModel;
        $c->forceFill(array_merge(['name' => 'Pat Customer', 'email' => 'pat_'.uniqid().'@example.com', 'password' => 'oldpass123', 'balance' => 0], $o))->save();

        return $c->fresh();
    }

    private function newCustomerData(array $o = []): array
    {
        return array_merge(['name' => 'New Person', 'email' => 'new_'.uniqid().'@example.com', 'phone' => '+971 50 111 2222',
            'company_name' => 'NewCo', 'account_status' => 'active', 'onboarding' => 'invite'], $o);
    }

    private function sentToken(CustomerModel $c, string $purpose): string
    {
        $token = null;
        Notification::assertSentTo($c, CustomerPasswordLink::class, function ($n) use ($purpose, &$token) {
            $token = $n->token;

            return $n->purpose === $purpose;
        });

        return $token;
    }

    // ---- public registration is closed ----

    public function test_public_registration_route_no_longer_creates_accounts(): void
    {
        $email = 'bypass_'.uniqid().'@example.com';
        $res = $this->post('/customer/register', ['name' => 'Sneaky', 'email' => $email, 'password' => 'password123']);
        $this->assertContains($res->status(), [404, 405]);
        $this->assertFalse(CustomerModel::where('email', $email)->exists());
        $this->assertFalse(Route::has('customer.handle.register'));
    }

    public function test_admin_self_registration_stays_disabled(): void
    {
        $this->get('/register')->assertNotFound();
        $this->post('/register', ['name' => 'x', 'email' => 'x@example.com', 'password' => 'secret123', 'password_confirmation' => 'secret123'])->assertStatus(405);
    }

    public function test_login_page_offers_recovery_not_registration(): void
    {
        $this->get(route('customer.login'))->assertOk()->assertSee('Forgot your password?')->assertDontSee('REGISTER');
    }

    // ---- admin creates accounts ----

    public function test_admin_creates_account_with_setup_link(): void
    {
        $admin = $this->admin();
        $data = $this->newCustomerData();
        $this->actingAs($admin)->post(route('admin.customer.store'), $data)->assertSessionHas('class', 'alert-success');

        $c = CustomerModel::where('email', $data['email'])->first();
        $this->assertSame($admin->id, (int) $c->created_by);
        $this->assertSame('active', $c->account_status);
        $this->assertFalse($c->must_change_password);
        $this->assertFalse(Hash::check('', $c->password));
        $this->sentToken($c, 'setup');
        $this->assertTrue(LogModel::where('mess', 'like', 'Customer #'.$c->id.': account created%')->where('added_by', $admin->id)->exists());
    }

    public function test_duplicate_email_is_rejected_case_insensitively(): void
    {
        $existing = $this->customer();
        $this->actingAs($this->admin())->post(route('admin.customer.store'), $this->newCustomerData(['email' => strtoupper($existing->email)]))
            ->assertSessionHasErrors('email');
        $this->assertSame(1, CustomerModel::where('email', $existing->email)->count());
    }

    public function test_create_validates_fields(): void
    {
        $this->actingAs($this->admin())->post(route('admin.customer.store'), $this->newCustomerData(['name' => '', 'email' => 'nope', 'account_status' => 'banned', 'onboarding' => 'plain']))
            ->assertSessionHasErrors(['name', 'email', 'account_status', 'onboarding']);
    }

    public function test_temporary_password_is_shown_once_never_stored_readably_and_forces_change(): void
    {
        $data = $this->newCustomerData(['onboarding' => 'temporary']);
        $res = $this->actingAs($this->admin())->post(route('admin.customer.store'), $data)->assertOk()->assertHeader('Cache-Control');
        preg_match('/id="tempPassword" value="([^"]+)"/', $res->getContent(), $m);
        $temp = $m[1] ?? '';
        $this->assertSame(14, strlen($temp));

        $c = CustomerModel::where('email', $data['email'])->first();
        $this->assertTrue($c->must_change_password);
        $this->assertNotSame($temp, $c->password);
        $this->assertTrue(Hash::check($temp, $c->password));
        $this->assertFalse(LogModel::where('mess', 'like', '%'.$temp.'%')->exists(), 'The password must never be logged.');
        $this->assertStringNotContainsString($temp, json_encode(session()->all()), 'The password must not be kept in the session.');
        Notification::assertNothingSentTo($c);

        // First login → forced to change; other pages redirect there until done.
        Auth::guard('web')->logout();
        $this->post('/customer/login', ['email' => $c->email, 'password' => $temp])->assertRedirect(route('customer.password.change'));
        $this->get(route('frontend.customer.dashboard.index'))->assertRedirect(route('customer.password.change'));
        $this->post(route('customer.password.change.update'), ['current_password' => $temp, 'password' => $temp, 'password_confirmation' => $temp])
            ->assertSessionHasErrors('password');
        $this->post(route('customer.password.change.update'), ['current_password' => $temp, 'password' => 'MyOwnPass99', 'password_confirmation' => 'MyOwnPass99'])
            ->assertRedirect(route('frontend.customer.dashboard.index'));
        $this->assertFalse($c->fresh()->must_change_password);
        $this->get(route('frontend.customer.dashboard.index'))->assertOk();
    }

    public function test_account_created_as_disabled_cannot_sign_in(): void
    {
        $data = $this->newCustomerData(['onboarding' => 'temporary', 'account_status' => 'disabled']);
        $res = $this->actingAs($this->admin())->post(route('admin.customer.store'), $data);
        preg_match('/id="tempPassword" value="([^"]+)"/', $res->getContent(), $m);
        Auth::guard('web')->logout();

        $this->post('/customer/login', ['email' => $data['email'], 'password' => $m[1]])->assertSessionHas('msg', fn ($v) => str_contains($v, 'disabled'));
        $this->assertGuest('customers');
    }

    // ---- self-service reset ----

    public function test_forgot_password_does_not_reveal_whether_an_account_exists(): void
    {
        $known = $this->customer();
        $this->post(route('customer.password.email'), ['email' => $known->email])->assertSessionHas('msg');
        $forKnown = session('msg');
        $this->post(route('customer.password.email'), ['email' => 'nobody_'.uniqid().'@example.com'])->assertSessionHas('msg');
        $this->assertSame($forKnown, session('msg'), 'Known and unknown emails must get the same reply.');
        $this->sentToken($known, 'reset');
    }

    public function test_reset_link_sets_new_password_once(): void
    {
        $c = $this->customer();
        $this->post(route('customer.password.email'), ['email' => $c->email]);
        $token = $this->sentToken($c, 'reset');

        $this->get(route('customer.password.reset', ['token' => $token, 'email' => $c->email]))->assertOk()->assertSee('Choose a new password');
        $this->post(route('customer.password.update'), ['token' => $token, 'email' => $c->email, 'password' => 'short', 'password_confirmation' => 'short'])
            ->assertSessionHasErrors('password');
        $this->post(route('customer.password.update'), ['token' => $token, 'email' => $c->email, 'password' => 'Brandnew123', 'password_confirmation' => 'Brandnew123'])
            ->assertRedirect(route('customer.login'));

        $c->refresh();
        $this->assertTrue(Hash::check('Brandnew123', $c->password));
        $this->assertNotNull($c->password_changed_at);
        $this->assertNotNull($c->email_verified_at);

        // Single use.
        $this->post(route('customer.password.update'), ['token' => $token, 'email' => $c->email, 'password' => 'Another123x', 'password_confirmation' => 'Another123x'])
            ->assertSessionHasErrors('email');
        $this->assertTrue(Hash::check('Brandnew123', $c->fresh()->password));
    }

    public function test_reset_token_cannot_be_used_as_setup_token_and_tokens_expire(): void
    {
        $c = $this->customer();
        $this->post(route('customer.password.email'), ['email' => $c->email]);
        $token = $this->sentToken($c, 'reset');

        $this->post(route('customer.password.update'), ['token' => $token, 'email' => $c->email, 'setup' => 1, 'password' => 'Brandnew123', 'password_confirmation' => 'Brandnew123'])
            ->assertSessionHasErrors('email');

        $this->travel(61)->minutes();
        $this->post(route('customer.password.update'), ['token' => $token, 'email' => $c->email, 'password' => 'Brandnew123', 'password_confirmation' => 'Brandnew123'])
            ->assertSessionHasErrors('email');
        $this->assertTrue(Hash::check('oldpass123', $c->fresh()->password));
    }

    public function test_forgot_password_is_rate_limited(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post(route('customer.password.email'), ['email' => 'flood@example.com']);
        }
        $this->post(route('customer.password.email'), ['email' => 'flood@example.com'])->assertStatus(429);
    }

    // ---- admin-initiated resets ----

    public function test_admin_sends_reset_link_and_is_throttled_per_customer(): void
    {
        $admin = $this->admin();
        $c = $this->customer();
        $this->actingAs($admin)->post(route('admin.customer.password.link', $c->id))->assertSessionHas('class', 'alert-success');
        $this->sentToken($c, 'reset');
        $this->assertTrue(LogModel::where('mess', 'like', 'Customer #'.$c->id.': password reset link emailed%')->exists());

        $this->actingAs($admin)->post(route('admin.customer.password.link', $c->id))->assertSessionHas('class', 'alert-warning');
        Notification::assertSentToTimes($c, CustomerPasswordLink::class, 1);
    }

    public function test_admin_temporary_password_replaces_old_one(): void
    {
        $c = $this->customer();
        $res = $this->actingAs($this->admin())->post(route('admin.customer.password.temporary', $c->id))->assertOk()->assertSee('shown only once');
        preg_match('/id="tempPassword" value="([^"]+)"/', $res->getContent(), $m);
        $c->refresh();
        $this->assertFalse(Hash::check('oldpass123', $c->password));
        $this->assertTrue(Hash::check($m[1], $c->password));
        $this->assertTrue($c->must_change_password);
    }

    public function test_only_admins_can_create_accounts_or_reset_passwords(): void
    {
        $c = $this->customer();
        $this->get(route('admin.customer.create'))->assertRedirect('/login');
        $this->post(route('admin.customer.store'), $this->newCustomerData())->assertRedirect('/login');
        $this->post(route('admin.customer.password.link', $c->id))->assertRedirect('/login');
        $this->post(route('admin.customer.password.temporary', $c->id))->assertRedirect('/login');

        Auth::guard('customers')->login($c);
        $this->post(route('admin.customer.password.temporary', $c->id))->assertRedirect('/login');
        $this->assertTrue(Hash::check('oldpass123', $c->fresh()->password));
        Notification::assertNothingSent();
    }

    public function test_profile_never_exposes_password_hash(): void
    {
        $c = $this->customer();
        $this->actingAs($this->admin())->get(route('admin.single.customer', $c->id))
            ->assertOk()->assertSee('Send password reset link')->assertDontSee($c->password, false);
    }
}
