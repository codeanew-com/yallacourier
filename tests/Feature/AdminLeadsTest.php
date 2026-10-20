<?php

namespace Tests\Feature;

use App\Models\FormModel;
use App\Models\OrderModel;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminLeadsTest extends TestCase
{
    use DatabaseTransactions;

    private function admin(): User
    {
        return User::create(['name' => 'Admin', 'email' => 'a_'.uniqid().'@example.com', 'password' => bcrypt('x12345678')]);
    }

    private function lead(array $o = []): FormModel
    {
        $l = FormModel::create(array_merge([
            'first_name' => 'Lena', 'last_name' => 'Lead'.uniqid(), 'email' => 'lena@example.com', 'phone' => '+971 50 123 4567',
            'position' => 'Ops', 'company_name' => 'Lenaco', 'number_of_parcel' => '40', 'current_delivery_partner' => 'Aramex',
        ], array_intersect_key($o, array_flip(['first_name', 'company_name']))));
        if (array_key_exists('read_at', $o) || array_key_exists('archived_at', $o)) {
            $l->forceFill(array_intersect_key($o, array_flip(['read_at', 'archived_at'])))->save();
        }

        return $l->fresh();
    }

    private function badge($admin): ?int
    {
        $html = $this->actingAs($admin)->get('/admin')->getContent();

        return preg_match('/<span class="visually-hidden">(\d+) unread business lead/', $html, $m) ? (int) $m[1] : null;
    }

    public function test_leads_routes_require_login(): void
    {
        $lead = $this->lead();
        $this->get(route('admin.businessleads.show', $lead->id))->assertRedirect('/login');
        $this->post(route('admin.businessleads.archive', $lead->id))->assertRedirect('/login');
        $this->delete(route('admin.businessleads.destroy', $lead->id))->assertRedirect('/login');
        $this->assertNotNull($lead->fresh());
    }

    public function test_new_leads_are_unread_and_opening_marks_them_read(): void
    {
        $admin = $this->admin();
        $lead = $this->lead();
        $this->assertTrue($lead->isUnread());

        $this->actingAs($admin)->get(route('admin.businessleads.show', $lead->id))
            ->assertOk()->assertSee($lead->email)->assertSee('Aramex')->assertSee('Back to leads');
        $this->assertNotNull($lead->fresh()->read_at);
    }

    public function test_sidebar_badge_counts_unread_inbox_leads_exactly(): void
    {
        $admin = $this->admin();
        $base = FormModel::unread()->count();
        $a = $this->lead();
        $b = $this->lead();
        $this->lead(['read_at' => now()]);              // read — not counted
        $this->lead(['archived_at' => now()]);          // archived unread — not counted

        $this->assertSame($base + 2, $this->badge($admin));

        $this->actingAs($admin)->get(route('admin.businessleads.show', $a->id));
        $this->actingAs($admin)->get(route('admin.businessleads.show', $a->id)); // viewing twice must not double count
        $this->assertSame($base + 1, $this->badge($admin));

        $this->actingAs($admin)->post(route('admin.businessleads.archive', $b->id));
        $this->assertSame($base ?: null, $this->badge($admin));

        $this->actingAs($admin)->post(route('admin.businessleads.unread', $a->id));
        $this->assertSame($base + 1, $this->badge($admin));

        $this->actingAs($admin)->delete(route('admin.businessleads.destroy', $a->id));
        $this->assertSame($base ?: null, $this->badge($admin));
    }

    public function test_archive_restore_and_tabs(): void
    {
        $admin = $this->admin();
        $lead = $this->lead(['first_name' => 'Archie']);

        $this->actingAs($admin)->post(route('admin.businessleads.archive', $lead->id))->assertSessionHas('class', 'alert-success');
        $this->assertNotNull($lead->fresh()->archived_at);
        $this->actingAs($admin)->get(route('admin.businessleads')); // consumes the flash message (it names the lead)
        $this->actingAs($admin)->get(route('admin.businessleads'))->assertDontSee($lead->last_name);
        $this->actingAs($admin)->get(route('admin.businessleads', ['view' => 'archived']))->assertSee($lead->last_name);

        $this->actingAs($admin)->post(route('admin.businessleads.restore', $lead->id));
        $this->assertNull($lead->fresh()->archived_at);
        $this->assertNotNull(FormModel::find($lead->id), 'Archiving must never delete.');
    }

    public function test_list_shows_essentials_not_every_field_and_searches(): void
    {
        $admin = $this->admin();
        $lead = $this->lead(['company_name' => 'Searchable Widgets']);
        $this->actingAs($admin)->get(route('admin.businessleads', ['q' => 'Searchable']))
            ->assertOk()->assertSee('Searchable Widgets · 40 parcels')->assertSee('View')->assertSee('Archive')
            ->assertDontSee('lena@example.com'); // contact details live on the detail page
        $this->actingAs($admin)->get(route('admin.businessleads', ['q' => 'zzznomatchzzz']))->assertSee('No leads match');
    }

    public function test_bulk_actions(): void
    {
        $admin = $this->admin();
        $a = $this->lead();
        $b = $this->lead();
        $this->actingAs($admin)->post(route('admin.businessleads.bulk'), ['action' => 'read', 'ids' => [$a->id, $b->id]]);
        $this->assertNotNull($a->fresh()->read_at);
        $this->actingAs($admin)->post(route('admin.businessleads.bulk'), ['action' => 'archive', 'ids' => [$a->id]]);
        $this->assertNotNull($a->fresh()->archived_at);
        $this->actingAs($admin)->post(route('admin.businessleads.bulk'), ['action' => 'delete', 'ids' => [$b->id]]);
        $this->assertNull(FormModel::find($b->id));
        $this->actingAs($admin)->post(route('admin.businessleads.bulk'), ['action' => 'nuke', 'ids' => [$a->id]])->assertSessionHasErrors('action');
    }

    public function test_public_form_creates_unread_lead(): void
    {
        $this->post(route('form.submit'), [
            'first_name' => 'Web', 'last_name' => 'Visitor'.uniqid(), 'email' => 'web@example.com', 'phone' => '0501', 'position' => 'Owner',
            'company_name' => 'Webco', 'number_of_parcel' => '100+', 'current_delivery_partner' => 'None',
        ])->assertRedirect(route('lead.thankyou'));
        $this->assertNull(FormModel::where('company_name', 'Webco')->latest('id')->first()->read_at);
    }

    public function test_public_form_stores_the_parcel_range_and_rejects_other_values(): void
    {
        $data = fn ($parcels) => [
            'first_name' => 'Range', 'last_name' => 'Test'.uniqid(), 'email' => 'range@example.com', 'phone' => '0501', 'position' => 'Owner',
            'company_name' => 'Rangeco', 'number_of_parcel' => $parcels, 'current_delivery_partner' => 'None',
        ];

        $this->post(route('form.submit'), $data('20-50'))->assertRedirect(route('lead.thankyou'));
        $this->assertSame('20-50', FormModel::where('company_name', 'Rangeco')->latest('id')->value('number_of_parcel'));

        $this->from('/business')->post(route('form.submit'), $data('3'))->assertSessionHasErrors('number_of_parcel');
        $this->from('/business')->post(route('form.submit'), $data('a million'))->assertSessionHasErrors('number_of_parcel');
    }

    public function test_migration_converts_old_option_codes_to_ranges(): void
    {
        $ids = [];
        foreach (['1', '2', '3', '4', '5', 'other'] as $code) {
            $ids[$code] = FormModel::create([
                'first_name' => 'Old', 'last_name' => 'Lead', 'email' => 'old@example.com', 'phone' => '0501', 'position' => 'x',
                'company_name' => 'Oldco', 'number_of_parcel' => $code, 'current_delivery_partner' => 'x',
            ])->id;
        }

        $migration = require database_path('migrations/2026_10_21_020000_store_parcel_ranges_on_business_leads.php');
        $migration->up();

        $stored = fn ($code) => FormModel::find($ids[$code])->number_of_parcel;
        $this->assertSame(['7-10', '10-12', '20-50', '50-100', '100+', 'other'], array_map($stored, ['1', '2', '3', '4', '5', 'other']));
    }

    public function test_orders_badge_counts_only_pending_and_follows_status_changes(): void
    {
        $admin = $this->admin();
        $count = fn () => preg_match('/<span class="visually-hidden">(\d+) pending order/', $this->actingAs($admin)->get('/admin')->getContent(), $m) ? (int) $m[1] : 0;
        $base = OrderModel::where('status', 'pending')->count();

        $o = new OrderModel;
        foreach (['customer_id' => 0, 'vat' => 0, 'total' => 0, 'subtotal' => 0, 'payment_status' => 0, 'courier' => 0, 'status' => 'pending'] as $k => $v) {
            $o->$k = $v;
        }
        $o->save();
        $p = $o->replicate();
        $p->status = 'processing';
        $p->save();
        $this->assertSame($base + 1, $count());

        $this->actingAs($admin)->post(route('admin.order.update', $o->id), [
            'status' => 'processing', 'payment_status' => '0', 'courier' => '0', 'subtotal' => '0', 'vat' => '0',
            'service_fee' => '0', 'over_head' => '0', 'courier_vat' => '0',
        ])->assertSessionHasNoErrors();
        $this->assertSame($base, $count());
    }
}
