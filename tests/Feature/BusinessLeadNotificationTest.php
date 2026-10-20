<?php

namespace Tests\Feature;

use App\Models\FormModel;
use App\Models\LogModel;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\NewBusinessLead;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

/** New business leads are emailed (queued) to the addresses set in Configuration → Notifications. */
class BusinessLeadNotificationTest extends TestCase
{
    use DatabaseTransactions;

    private function admin(): User
    {
        return User::create(['name' => 'Admin', 'email' => 'a_'.uniqid().'@example.com', 'password' => bcrypt('x12345678')]);
    }

    private function lead(array $o = []): array
    {
        return array_merge([
            'first_name' => 'Rohan', 'last_name' => 'Rao', 'email' => 'rohan@quasar.example', 'phone' => '0501234567',
            'position' => 'Ops Manager', 'company_name' => 'Quasar Dynamics', 'number_of_parcel' => '200',
            'current_delivery_partner' => 'Aramex',
        ], $o);
    }

    public function test_default_recipient_is_quotes_at_yallashipping(): void
    {
        $this->assertSame('quotes@yallashipping.com', Setting::get(Setting::BUSINESS_LEAD_EMAILS));
    }

    public function test_new_lead_is_saved_and_a_queued_email_goes_to_the_configured_addresses(): void
    {
        Notification::fake();
        Setting::put(Setting::BUSINESS_LEAD_EMAILS, 'quotes@yallashipping.com, sales@example.com');

        $this->post(route('form.submit'), $this->lead())->assertRedirect(route('lead.thankyou'));

        $lead = FormModel::where('email', 'rohan@quasar.example')->latest('id')->firstOrFail();
        Notification::assertSentTo(new AnonymousNotifiable, NewBusinessLead::class, function ($n, $channels, $notifiable) use ($lead) {
            return $n->lead->is($lead) && $notifiable->routes['mail'] === ['quotes@yallashipping.com', 'sales@example.com'];
        });
        $this->assertInstanceOf(ShouldQueue::class, new NewBusinessLead($lead));
    }

    public function test_email_content_and_reply_to_the_lead(): void
    {
        $lead = FormModel::create($this->lead());
        $mail = (new NewBusinessLead($lead))->toMail(new AnonymousNotifiable);

        $this->assertSame('New business lead: Quasar Dynamics', $mail->subject);
        $this->assertSame([['rohan@quasar.example', 'Rohan Rao']], $mail->replyTo);
        $this->assertSame(route('admin.businessleads.show', $lead->id), $mail->actionUrl);
        $this->assertStringContainsString('Aramex', implode(' ', $mail->introLines));
    }

    public function test_no_email_when_notifications_are_turned_off(): void
    {
        Notification::fake();
        Setting::put(Setting::BUSINESS_LEAD_EMAILS, '');

        $this->post(route('form.submit'), $this->lead())->assertRedirect(route('lead.thankyou'));

        Notification::assertNothingSent();
        $this->assertTrue(FormModel::where('email', 'rohan@quasar.example')->exists());
    }

    public function test_admin_can_change_the_addresses_and_it_is_logged(): void
    {
        $admin = $this->admin();
        $this->actingAs($admin)->get(route('admin.settings.notifications'))->assertOk()->assertSee('quotes@yallashipping.com');

        $this->actingAs($admin)->put(route('admin.settings.notifications.update'), ['business_lead_emails' => " Quotes@YallaShipping.com ;\nboss@example.com, quotes@yallashipping.com "])
            ->assertRedirect(route('admin.settings.notifications'))->assertSessionHas('class', 'alert-success');

        $this->assertSame('quotes@yallashipping.com, boss@example.com', Setting::get(Setting::BUSINESS_LEAD_EMAILS));
        $this->assertTrue(LogModel::where('mess', 'like', 'Business lead notification emails changed:%boss@example.com%')->exists());
    }

    public function test_invalid_addresses_are_rejected_and_nothing_is_saved(): void
    {
        $this->actingAs($this->admin())->from(route('admin.settings.notifications'))
            ->put(route('admin.settings.notifications.update'), ['business_lead_emails' => 'quotes@yallashipping.com, not-an-email'])
            ->assertRedirect(route('admin.settings.notifications'))
            ->assertSessionHasErrors('business_lead_emails');

        $this->assertSame('quotes@yallashipping.com', Setting::get(Setting::BUSINESS_LEAD_EMAILS));
    }

    public function test_settings_page_requires_admin_login(): void
    {
        $this->get(route('admin.settings.notifications'))->assertRedirect('/login');
        $this->put(route('admin.settings.notifications.update'), ['business_lead_emails' => 'x@example.com'])->assertRedirect('/login');
    }
}
