<?php

namespace Tests\Feature;

use App\Models\CustomerModel;
use App\Models\OrderModel;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

/**
 * How each form reports invalid input. The public and customer templates show
 * one flashed `msg` line (no error bag); admin forms use the error bag, and a
 * few also flash a `msg`/`class` banner. These are the templates' contract.
 */
class FormRequestFailureTest extends TestCase
{
    use DatabaseTransactions;

    private function admin(): User
    {
        return User::create(['name' => 'Admin', 'email' => 'a_'.uniqid().'@example.com', 'password' => bcrypt('x12345678')]);
    }

    private function customer(): CustomerModel
    {
        $c = new CustomerModel;
        $c->forceFill(['name' => 'Cara', 'email' => 'cara_'.uniqid().'@example.com', 'password' => 'password123', 'balance' => 0])->save();

        return $c->fresh();
    }

    private function order(int $customerId): OrderModel
    {
        $o = new OrderModel;
        foreach (['customer_id' => $customerId, 'vat' => 0, 'total' => 0, 'subtotal' => 0, 'payment_status' => 0, 'courier' => 0, 'status' => 'pending'] as $k => $v) {
            $o->$k = $v;
        }
        $o->save();

        return $o;
    }

    public function test_booking_form_flashes_first_error_and_keeps_input(): void
    {
        $before = OrderModel::count();

        $this->from('/')->post(route('front.shipment.request'), ['sender_name' => 'Sam', 'sender_email' => 'bad'])
            ->assertRedirect('/')
            ->assertSessionHas('msg', 'The sender phone field is required.')
            ->assertSessionHasInput('sender_name', 'Sam')
            ->assertSessionDoesntHaveErrors();

        $this->assertSame($before, OrderModel::count());
    }

    public function test_email_with_line_break_is_rejected(): void
    {
        $before = OrderModel::count();

        $this->from('/')->post(route('front.shipment.request'), [
            'sender_name' => 'Sam', 'sender_phone' => '0501234567', 'sender_email' => "sam@example.com\r\nBcc: victim@example.com",
            'reciever_name' => 'Rae', 'reciever_phone' => '0507654321', 'reciever_email' => 'rae@example.com',
            'shipment_qty' => [1], 'shipment_length' => [10], 'shipment_width' => [10], 'shipment_height' => [10], 'shipment_weight' => [1],
        ])->assertRedirect('/')->assertSessionHas('msg');

        $this->assertSame($before, OrderModel::count());
    }

    public function test_customer_login_flashes_first_error_without_input(): void
    {
        $this->from(route('customer.login'))->post(route('customer.handle.login'), ['email' => 'not-an-email'])
            ->assertRedirect(route('customer.login'))
            ->assertSessionHas('msg', 'The email field must be a valid email address.')
            ->assertSessionMissing('_old_input')
            ->assertSessionDoesntHaveErrors();
    }

    public function test_customer_profile_update_validates_and_saves(): void
    {
        $c = $this->customer();
        Auth::guard('customers')->login($c);

        $this->from(route('frontend.customer.setting.index'))->post(route('frontend.customer.setting.update'), ['name' => ''])
            ->assertRedirect(route('frontend.customer.setting.index'))
            ->assertSessionHas('msg', 'The name field is required.');

        $this->from(route('frontend.customer.setting.index'))->post(route('frontend.customer.setting.update'), ['name' => 'Cara Two', 'company_name' => 'Acme', 'phone' => '050 1234567'])
            ->assertRedirect(route('frontend.customer.setting.index'))
            ->assertSessionHas('profile_msg', 'Profile updated successfully.');
        $this->assertSame('Cara Two', $c->fresh()->name);
        $this->assertSame('Acme', $c->fresh()->company_name);
    }

    public function test_customer_sees_only_their_own_shipments(): void
    {
        $c = $this->customer();
        $mine = $this->order($c->id);
        $theirs = $this->order($this->customer()->id);
        Auth::guard('customers')->login($c);

        $this->get(route('customer.view.order', $mine->id))->assertOk()->assertViewIs('customer.shipments.view')->assertViewHas('o', fn ($o) => $o->id === $mine->id);
        $this->get(route('customer.view.order', $theirs->id))->assertNotFound();
    }

    public function test_failed_order_update_flashes_banner_with_errors(): void
    {
        $order = $this->order(0);

        $this->actingAs($this->admin())->from(route('admin.view.order', $order->id))
            ->post(route('admin.order.update', $order->id), ['status' => 'shipped'])
            ->assertRedirect(route('admin.view.order', $order->id))
            ->assertSessionHasErrors('status')
            ->assertSessionHas('msg', 'Nothing was saved — please fix the highlighted fields.')
            ->assertSessionHas('class', 'alert-danger');
    }

    public function test_failed_status_change_uses_status_error_bag_and_banner(): void
    {
        $c = $this->customer();

        $this->actingAs($this->admin())->from(route('admin.single.customer', $c->id))
            ->post(route('admin.customer.status', $c->id), ['action' => 'ban'])
            ->assertRedirect(route('admin.single.customer', $c->id))
            ->assertSessionHasErrorsIn('status', ['reason'])
            ->assertSessionHas('class', 'alert-danger')
            ->assertSessionHas('msg', fn ($m) => str_contains($m, 'Please give a reason'));
    }

    public function test_status_change_on_missing_customer_is_404(): void
    {
        $this->actingAs($this->admin())->post(route('admin.customer.status', 999999999), ['action' => 'ban', 'reason' => 'x'])->assertNotFound();
        $this->actingAs($this->admin())->patch(route('admin.customer.update', 999999999), ['name' => 'x', 'email' => 'x@example.com'])->assertNotFound();
    }
}
