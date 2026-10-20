<?php

namespace Tests\Feature;

use App\Models\CustomerModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CustomerAuthTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->markTestSkipped('Customer login/register routes disabled per owner request (2026-10-03). Controller/views untouched; re-enable these tests if the routes are restored.');
    }

    public function test_customer_can_register_and_is_logged_in(): void
    {
        $email = 'test_'.uniqid().'@example.com';

        $response = $this->post('/customer/register', [
            'name' => 'Test Customer',
            'email' => $email,
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('frontend.customer.dashboard.index'));
        $this->assertDatabaseHas('customers', ['email' => $email]);
        $this->assertAuthenticated('customers');
    }

    public function test_customer_can_login_with_correct_credentials(): void
    {
        $email = 'test_'.uniqid().'@example.com';
        $customer = new CustomerModel;
        $customer->name = 'Test Customer';
        $customer->email = $email;
        $customer->password = bcrypt('password123');
        $customer->balance = 0;
        $customer->save();

        $response = $this->post('/customer/login', [
            'email' => $email,
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('frontend.customer.dashboard.index'));
        $this->assertAuthenticatedAs($customer, 'customers');
    }

    public function test_customer_cannot_login_with_wrong_password(): void
    {
        $email = 'test_'.uniqid().'@example.com';
        CustomerModel::create([
            'name' => 'Test Customer',
            'email' => $email,
            'password' => bcrypt('password123'),
            'balance' => 0,
        ]);

        $response = $this->post('/customer/login', [
            'email' => $email,
            'password' => 'wrong-password',
        ]);

        $response->assertRedirect();
        $this->assertGuest('customers');
    }

    public function test_login_with_empty_credentials_does_not_crash(): void
    {
        $response = $this->post('/customer/login', [
            'email' => '',
            'password' => '',
        ]);

        $response->assertStatus(302);
        $this->assertGuest('customers');
    }

    public function test_register_rejects_invalid_email_and_short_password(): void
    {
        $response = $this->post('/customer/register', [
            'name' => 'Test',
            'email' => 'not-an-email',
            'password' => '123',
        ]);

        $response->assertStatus(302);
        $this->assertGuest('customers');
        $this->assertDatabaseMissing('customers', ['name' => 'Test']);
    }

    public function test_login_is_rate_limited_after_five_attempts(): void
    {
        $email = 'test_'.uniqid().'@example.com';

        for ($i = 0; $i < 5; $i++) {
            $response = $this->post('/customer/login', [
                'email' => $email,
                'password' => 'wrong-password',
            ]);
            $response->assertStatus(302);
        }

        $response = $this->post('/customer/login', [
            'email' => $email,
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(429);
    }
}
