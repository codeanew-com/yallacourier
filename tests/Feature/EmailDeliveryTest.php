<?php

namespace Tests\Feature;

use App\Models\CourierModel;
use App\Models\CustomerModel;
use App\Models\LogModel;
use App\Models\OrderMetaModel;
use App\Models\OrderModel;
use App\Models\User;
use App\Notifications\CustomerPasswordLink;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\SentMessage;
use Tests\TestCase;

/**
 * Email workflows. phpunit.xml sets MAIL_MAILER=array, so every message goes
 * through the real Laravel mailer and is kept in memory (nothing is sent),
 * which lets these tests inspect the actual From/To headers.
 */
class EmailDeliveryTest extends TestCase
{
    use DatabaseTransactions;

    /** @return SentMessage[] */
    private function sent(): array
    {
        return app('mail.manager')->mailer('array')->getSymfonyTransport()->messages()->all();
    }

    private function bookingPayload(array $o = []): array
    {
        return array_merge([
            'sender_name' => 'Sam Sender', 'sender_phone' => '0501112222', 'sender_email' => 'sam@example.com',
            'reciever_name' => 'Rita Receiver', 'reciever_phone' => '0503334444', 'reciever_email' => 'rita@example.com',
            'shipment_from' => 'Dubai', 'shipment_to' => 'Abu Dhabi', 'shipment_from_1' => 'Al Barsha', 'searchdeladd' => 'Khalifa City',
            'shipment_qty' => [1], 'shipment_length' => [10], 'shipment_width' => [10], 'shipment_height' => [10], 'shipment_weight' => [1],
        ], $o);
    }

    public function test_booking_sends_confirmation_to_sender_and_receiver_from_the_authenticated_mailbox(): void
    {
        config(['mail.from.address' => 'no-reply@yallacourier.com']);
        $this->post(route('front.shipment.request'), $this->bookingPayload())->assertRedirect();

        $order = OrderModel::latest('id')->first();
        $messages = $this->sent();
        $this->assertCount(2, $messages);
        $to = [];
        foreach ($messages as $m) {
            $email = $m->getOriginalMessage();
            // The outage: order mail used a hardcoded notification@ sender that the SMTP server refuses (553 5.7.1).
            $this->assertSame('no-reply@yallacourier.com', $email->getFrom()[0]->getAddress());
            $this->assertStringContainsString('#'.$order->id, $email->getSubject());
            $this->assertNotEmpty($email->getTextBody(), 'A plain-text part must be present.');
            $this->assertStringNotContainsString('<table', $email->getTextBody());
            $this->assertStringContainsString('We have received your shipment request', $email->getHtmlBody());
            $this->assertStringNotContainsString('accepted</strong> by the courier', $email->getHtmlBody());
            $this->assertStringNotContainsString('stripocdn', $email->getHtmlBody(), 'Expired CDN images must be gone.');
            $this->assertStringContainsString('mai-logo.png', $email->getHtmlBody());
            $to[] = $email->getTo()[0]->getAddress();
        }
        $this->assertEqualsCanonicalizing(['sam@example.com', 'rita@example.com'], $to);
        $this->assertTrue(LogModel::where('mess', 'Order #'.$order->id.': booking confirmation email sender sent, receiver sent')->exists());
    }

    public function test_booking_is_saved_even_if_email_fails_and_failure_is_recorded(): void
    {
        Mail::shouldReceive('send')->andThrow(new TransportException('Connection could not be established'));
        $before = OrderModel::count();

        $this->post(route('front.shipment.request'), $this->bookingPayload())->assertRedirect();

        $this->assertSame($before + 1, OrderModel::count(), 'A mail outage must never lose a booking.');
        $order = OrderModel::latest('id')->first();
        $this->assertTrue(LogModel::where('mess', 'like', 'Order #'.$order->id.': booking confirmation email sender FAILED%')->exists());
    }

    public function test_admin_resend_works_for_orders_without_a_courier_and_reports_result(): void
    {
        $order = new OrderModel;
        foreach (['customer_id' => 0, 'vat' => 0, 'total' => 0, 'subtotal' => 0, 'payment_status' => 0, 'courier' => 0, 'status' => 'pending'] as $k => $v) {
            $order->$k = $v;
        }
        $order->save();
        foreach (['sender_email' => 'sam@example.com', 'sender_name' => 'Sam', 'reciever_email' => 'rita@example.com', 'reciever_name' => 'Rita'] as $k => $v) {
            $m = new OrderMetaModel;
            $m->order_id = $order->id;
            $m->key = $k;
            $m->value = $v;
            $m->save();
        }
        $admin = User::create(['name' => 'A', 'email' => 'a_'.uniqid().'@example.com', 'password' => bcrypt('x12345678')]);

        // This used to crash with "Attempt to read property name on null" for unassigned orders.
        $this->actingAs($admin)->get(route('admin.sendemails', $order->id))
            ->assertRedirect()->assertSessionHas('class', 'alert-success');
        $this->assertCount(4, $this->sent());
    }

    public function test_invoice_shows_real_payment_method(): void
    {
        $o = new OrderModel;
        $o->forceFill(['id' => 1, 'total' => 20, 'subtotal' => 20, 'vat' => 0, 'service_fee' => 0, 'payment_status' => 0, 'payment_from' => null]);
        $html = view('mails.orderdetail', ['name' => 'X', 'courier' => null, 'order' => $o, 'addr' => '', 'state' => '', 'country' => ''])->render();
        $this->assertStringContainsString('Payment pending', $html);
        $o->payment_from = 'Stripe';
        $this->assertStringContainsString('Card', view('mails.orderdetail', ['name' => 'X', 'courier' => CourierModel::first(), 'order' => $o, 'addr' => '', 'state' => '', 'country' => ''])->render());
    }

    public function test_public_unauthenticated_mail_trigger_is_gone(): void
    {
        $this->assertFalse(Route::has('front.mails'));
        $this->get('/send/emails/1')->assertNotFound();
        $this->assertCount(0, $this->sent());
    }

    public function test_notification_emails_are_branded_yalla_not_laravel(): void
    {
        config(['app.name' => 'Yalla Courier', 'mail.from.address' => 'no-reply@yallacourier.com']);
        $c = new CustomerModel;
        $c->forceFill(['name' => 'Pat', 'email' => 'pat_'.uniqid().'@example.com', 'password' => 'x12345678a', 'balance' => 0])->save();

        $c->notify(new CustomerPasswordLink('tok', 'reset'));

        $email = $this->sent()[0]->getOriginalMessage();
        $html = $email->getHtmlBody();
        $this->assertSame('no-reply@yallacourier.com', $email->getFrom()[0]->getAddress());
        $this->assertStringNotContainsString('Laravel', $html);
        $this->assertStringContainsString('mai-logo.png', $html);
        $this->assertStringContainsString('© '.date('Y').' Yalla Courier. All rights reserved.', $html);
    }
}
