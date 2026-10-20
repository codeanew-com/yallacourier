<?php

namespace Tests\Feature;

use App\Models\CustomerModel;
use App\Models\LogModel;
use App\Models\OrderModel;
use App\Models\User;
use App\Services\Customers\CustomerSessionRevoker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AdminCustomerManagementTest extends TestCase
{
    use DatabaseTransactions;

    private function admin(): User
    {
        return User::create(['name' => 'Admin', 'email' => 'a_'.uniqid().'@example.com', 'password' => bcrypt('x12345678')]);
    }

    private function customer(array $o = []): CustomerModel
    {
        $c = new CustomerModel;
        $c->forceFill(array_merge([
            'name' => 'Cara Customer', 'email' => 'cara_'.uniqid().'@example.com', 'password' => 'password123',
            'phone' => '0501234567', 'company_name' => 'Cara Trading', 'balance' => 25,
        ], $o))->save();

        return $c->fresh();
    }

    private function order(CustomerModel $c, array $o = []): OrderModel
    {
        $order = new OrderModel;
        foreach (array_merge(['customer_id' => $c->id, 'vat' => 0, 'total' => 50, 'subtotal' => 50, 'payment_status' => 0, 'courier' => 0, 'status' => 'pending'], $o) as $k => $v) {
            $order->$k = $v;
        }
        $order->save();

        return $order;
    }

    // ---- permissions ----

    public function test_guests_and_customers_cannot_use_admin_customer_actions(): void
    {
        $c = $this->customer();
        foreach ([
            ['get', route('admin.view.customer')], ['get', route('admin.single.customer', $c->id)], ['get', route('admin.customer.edit', $c->id)],
        ] as [$m, $url]) {
            $this->$m($url)->assertRedirect('/login');
        }
        $this->patch(route('admin.customer.update', $c->id), ['name' => 'Hacked', 'email' => $c->email])->assertRedirect('/login');

        // A logged-in *customer* is not an admin.
        $other = $this->customer();
        // Log in through the customers guard the way Customer\AuthController does (actingAs() would also
        // switch the *default* guard, which the real app never does).
        Auth::guard('customers')->login($other);
        $this->post(route('admin.customer.status', $c->id), ['action' => 'ban', 'reason' => 'x'])->assertRedirect('/login');
        $this->assertSame('active', $c->fresh()->account_status);
        $this->assertSame('Cara Customer', $c->fresh()->name);
    }

    // ---- list & profile ----

    public function test_list_shows_status_order_totals_and_filters(): void
    {
        $admin = $this->admin();
        $c = $this->customer(['name' => 'Listy Uniquename']);
        $this->order($c, ['total' => 40]);
        $this->order($c, ['total' => 99, 'status' => 'cancelled']);
        $banned = $this->customer(['name' => 'Banny Uniquename', 'account_status' => 'banned']);

        $this->actingAs($admin)->get(route('admin.view.customer', ['q' => 'Uniquename']))
            ->assertOk()->assertSee('Listy Uniquename')->assertSee('AED 40.00')->assertSee('Banned')->assertSee('Suspend / ban')->assertSee('Reactivate');
        $this->actingAs($admin)->get(route('admin.view.customer', ['status' => 'banned', 'q' => 'Uniquename']))
            ->assertSee('Banny Uniquename')->assertDontSee('Listy Uniquename');
    }

    public function test_profile_shows_all_sections_without_secrets(): void
    {
        $c = $this->customer();
        $this->order($c, ['total' => 30, 'payment_status' => 1]);
        $this->order($c, ['total' => 20]);

        $res = $this->actingAs($this->admin())->get(route('admin.single.customer', $c->id))->assertOk();
        foreach (['Overview', 'Payments &amp; invoices', 'Addresses', 'Wallet', 'Activity', 'Cara Trading', '0501234567', 'Last login', 'AED 20.00'] as $text) {
            $res->assertSee($text, false);
        }
        $res->assertDontSee($c->getAuthPassword(), false);
    }

    // ---- editing ----

    public function test_edit_validates_and_prevents_duplicate_email(): void
    {
        $admin = $this->admin();
        $taken = $this->customer();
        $c = $this->customer();

        $this->actingAs($admin)->patch(route('admin.customer.update', $c->id), ['name' => '', 'email' => strtoupper($taken->email), 'phone' => 'call me'])
            ->assertSessionHasErrors(['name', 'email', 'phone']);
        $this->assertSame('Cara Customer', $c->fresh()->name);
    }

    public function test_edit_saves_and_writes_audit_log_but_never_touches_password_or_balance(): void
    {
        $c = $this->customer(['email_verified_at' => now()]);
        $hash = $c->password;

        $this->actingAs($this->admin())->patch(route('admin.customer.update', $c->id), [
            'name' => 'Cara Renamed', 'email' => 'NEW_'.$c->email, 'phone' => '+971 55 000 1111', 'company_name' => 'Cara LLC', 'designation' => 'Owner',
            'password' => 'injected', 'balance' => 99999, 'account_status' => 'active',
        ])->assertRedirect(route('admin.single.customer', $c->id));

        $c->refresh();
        $this->assertSame('Cara Renamed', $c->name);
        $this->assertSame(strtolower('NEW_'.$c->email) === $c->email ? $c->email : $c->email, $c->email);
        $this->assertStringStartsWith('new_', $c->email);
        $this->assertNull($c->email_verified_at, 'A changed email is no longer verified.');
        $this->assertSame($hash, $c->password);
        $this->assertEquals(25, $c->balance);

        $log = LogModel::where('mess', 'like', 'Customer #'.$c->id.':%')->latest('id')->first();
        $this->assertStringContainsString('name "Cara Customer" → "Cara Renamed"', $log->mess);
        $this->assertStringNotContainsString('injected', $log->mess);
    }

    // ---- access control ----

    public function test_suspend_requires_reason_and_future_expiry(): void
    {
        $c = $this->customer();
        $this->actingAs($this->admin())->post(route('admin.customer.status', $c->id), ['action' => 'suspend', 'reason' => '', 'suspended_until' => '2000-01-01 00:00'])
            ->assertSessionHasErrors(['reason', 'suspended_until'], null, 'status');
        $this->assertSame('active', $c->fresh()->account_status);
    }

    public function test_banned_customer_cannot_log_in(): void
    {
        $c = $this->customer();
        $this->actingAs($this->admin())->post(route('admin.customer.status', $c->id), ['action' => 'ban', 'reason' => 'Fraudulent chargebacks']);
        Auth::guard('web')->logout();

        $this->assertSame('banned', $c->fresh()->account_status);
        $this->post('/customer/login', ['email' => $c->email, 'password' => 'password123'])
            ->assertRedirect()->assertSessionHas('msg', fn ($m) => str_contains($m, 'banned'));
        $this->assertGuest('customers');
    }

    public function test_wrong_password_does_not_reveal_ban(): void
    {
        $c = $this->customer(['account_status' => 'banned']);
        $this->post('/customer/login', ['email' => $c->email, 'password' => 'wrong'])->assertSessionHas('msg', 'Invalid Username Or Password!');
    }

    public function test_active_customer_login_records_last_login(): void
    {
        $c = $this->customer();
        $this->post('/customer/login', ['email' => $c->email, 'password' => 'password123'])->assertRedirect(route('frontend.customer.dashboard.index'));
        $this->assertAuthenticatedAs($c, 'customers');
        $this->assertNotNull($c->fresh()->last_login_at);
    }

    public function test_existing_session_is_cut_off_on_next_request_when_suspended(): void
    {
        $c = $this->customer();
        $this->actingAs($c, 'customers')->get(route('frontend.customer.dashboard.index'))->assertOk();

        // Admin suspends while the customer is still logged in (no re-login needed for the block to apply).
        DB::table('customers')->where('id', $c->id)->update(['account_status' => 'suspended', 'status_reason' => 'Review']);

        $this->get(route('frontend.customer.dashboard.index'))->assertRedirect(route('customer.login'));
        $this->assertGuest('customers');
    }

    public function test_session_revoker_deletes_only_that_customers_database_sessions(): void
    {
        config(['session.driver' => 'database', 'session.encrypt' => false]);
        $c = $this->customer();
        $other = $this->customer();
        $key = Auth::guard('customers')->getName();
        $mk = fn ($id, $data) => DB::table('sessions')->insert(['id' => $id, 'payload' => base64_encode(serialize($data)), 'last_activity' => time()]);
        $mk('sess_mine_'.uniqid(), ['_token' => 'x', $key => $c->id]);
        $mk('sess_other_'.uniqid(), ['_token' => 'y', $key => $other->id]);
        $mk('sess_admin_'.uniqid(), ['_token' => 'z', 'login_web_abc' => $c->id]); // admin session with same numeric id

        $this->assertSame(1, app(CustomerSessionRevoker::class)->revoke($c));
        $this->assertSame(0, DB::table('sessions')->where('id', 'like', 'sess_mine_%')->count());
        $this->assertSame(1, DB::table('sessions')->where('id', 'like', 'sess_other_%')->count());
        $this->assertSame(1, DB::table('sessions')->where('id', 'like', 'sess_admin_%')->count());
    }

    public function test_reactivate_restores_access_and_keeps_financial_records(): void
    {
        $admin = $this->admin();
        $c = $this->customer();
        $order = $this->order($c, ['total' => 75, 'payment_status' => 1]);

        $this->actingAs($admin)->post(route('admin.customer.status', $c->id), ['action' => 'disable', 'reason' => 'Requested by customer']);
        $this->assertSame('disabled', $c->fresh()->account_status);
        $this->assertNotNull(OrderModel::find($order->id), 'Disabling must not delete orders.');

        $this->actingAs($admin)->post(route('admin.customer.status', $c->id), ['action' => 'reactivate']);
        $c->refresh();
        $this->assertSame('active', $c->account_status);
        $this->assertNull($c->status_reason);
        $this->assertEquals(25, $c->balance);

        $mess = LogModel::where('mess', 'like', 'Customer #'.$c->id.':%')->orderBy('id')->pluck('mess')->implode("\n");
        $this->assertStringContainsString('active → disabled; reason: Requested by customer', $mess);
        $this->assertStringContainsString('disabled → active', $mess);
    }

    public function test_suspension_with_expiry_lapses_automatically(): void
    {
        $c = $this->customer(['account_status' => 'suspended', 'suspended_until' => now()->addDay()]);
        $this->assertTrue($c->isBlocked());

        $this->travel(2)->days();
        $this->assertFalse($c->fresh()->isBlocked());
        $this->assertTrue(CustomerModel::withStatus('active')->whereKey($c->id)->exists());
        $this->assertFalse(CustomerModel::withStatus('suspended')->whereKey($c->id)->exists());
    }

    public function test_sign_out_everywhere_keeps_account_active(): void
    {
        $c = $this->customer();
        $this->actingAs($this->admin())->post(route('admin.customer.sessions.revoke', $c->id))->assertSessionHas('class', 'alert-success');
        $this->assertSame('active', $c->fresh()->account_status);
        $this->assertTrue(LogModel::where('mess', 'like', 'Customer #'.$c->id.': signed out of all devices%')->exists());
    }
}
