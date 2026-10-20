<?php

namespace Tests\Feature;

use App\Models\CustomerModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CustomerDashboardTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->markTestSkipped('Customer dashboard/shipment-setting routes disabled per owner request (2026-10-03). Controller/views untouched; re-enable these tests if the routes are restored.');
    }

    private function makeCustomer(): CustomerModel
    {
        $customer = new CustomerModel;
        $customer->name = 'Test Customer';
        $customer->email = 'test_'.uniqid().'@example.com';
        $customer->password = bcrypt('password123');
        $customer->balance = 0;
        $customer->save();

        return $customer;
    }

    public function test_dashboard_loads_for_authenticated_customer(): void
    {
        $customer = $this->makeCustomer();

        $response = $this->actingAs($customer, 'customers')->get('/customer/dashboard');

        $response->assertOk();
    }

    public function test_dashboard_redirects_guest_to_login(): void
    {
        $response = $this->get('/customer/dashboard');

        $response->assertRedirect();
        $this->assertGuest('customers');
    }

    public function test_shipment_setting_loads_for_authenticated_customer(): void
    {
        $customer = $this->makeCustomer();

        $response = $this->actingAs($customer, 'customers')->get('/customer/shipment-setting');

        $response->assertOk();
    }
}
