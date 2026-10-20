<?php

namespace Tests\Feature;

use App\Http\Controllers\Admin\CustomerController;
use App\Models\CustomerModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class CustomerTopupTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->markTestSkipped('Customer wallet/top-up routes disabled per owner request (2026-10-03) — tied to the disabled customer account system. Controller/views untouched; re-enable these tests if the routes are restored.');
    }

    private function makeCustomer(float $balance = 0): CustomerModel
    {
        $customer = new CustomerModel;
        $customer->name = 'Test Customer';
        $customer->email = 'test_'.uniqid().'@example.com';
        $customer->password = bcrypt('password123');
        $customer->balance = $balance;
        $customer->save();

        return $customer;
    }

    public function test_add_topup_rejects_missing_or_non_numeric_amount(): void
    {
        $customer = $this->makeCustomer();

        $response = $this->actingAs($customer, 'customers')->post('/customer/topup', [
            'customer_id' => $customer->id,
            'amount_to_load' => 'not-a-number',
        ]);

        $response->assertStatus(302);
        $this->assertNull(Session::get('customer_topup'));
    }

    public function test_add_topup_only_stores_amount_never_client_supplied_customer_id(): void
    {
        $victim = $this->makeCustomer();
        $attacker = $this->makeCustomer();

        $this->actingAs($attacker, 'customers')->post('/customer/topup', [
            'customer_id' => $victim->id, // attacker tries to impersonate the victim
            'amount_to_load' => 50,
        ]);

        $stored = Session::get('customer_topup');
        $this->assertArrayNotHasKey('customer_id', $stored);
        $this->assertEquals(50, $stored['amount_to_load']);
    }

    public function test_savetopup_always_attributes_records_to_the_authenticated_customer(): void
    {
        $victim = $this->makeCustomer(balance: 0);
        $attacker = $this->makeCustomer(balance: 0);

        // Simulate the session state an attacker could have produced under the
        // OLD vulnerable code (customer_id sourced from raw client input),
        // to prove savetopup() no longer trusts it even if present.
        Session::put('customer_topup', ['amount_to_load' => 100, 'customer_id' => $victim->id]);
        Auth::guard('customers')->login($attacker);

        $controller = new CustomerController;
        $request = Request::create('/topup/confim', 'GET', [
            'payment_intent' => 'pi_test_123',
            'payment_intent_client_secret' => 'secret_test_123',
        ]);
        $controller->savetopup($request);

        $this->assertDatabaseHas('customer_top_up', [
            'customer_id' => $attacker->id,
            'amount' => 100,
        ]);
        $this->assertDatabaseMissing('customer_top_up', [
            'customer_id' => $victim->id,
        ]);

        $this->assertDatabaseHas('system_transactions', [
            'customer_id' => $attacker->id,
            'ref_point' => 'topup_payment',
        ]);

        $attacker->refresh();
        $victim->refresh();
        $this->assertEquals(100, $attacker->balance);
        $this->assertEquals(0, $victim->balance);
    }
}
