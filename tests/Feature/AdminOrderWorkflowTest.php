<?php

namespace Tests\Feature;

use App\Models\CourierModel;
use App\Models\LogModel;
use App\Models\OrderDimensionModel;
use App\Models\OrderMetaModel;
use App\Models\OrderModel;
use App\Models\User;
use App\Services\Orders\OrderPricing;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminOrderWorkflowTest extends TestCase
{
    use DatabaseTransactions;

    private function admin(): User
    {
        return User::create([
            'name' => 'Test Admin',
            'email' => 'admin_'.uniqid().'@example.com',
            'password' => bcrypt('secret123'),
        ]);
    }

    private function courier(array $overrides = []): CourierModel
    {
        $c = new CourierModel;
        foreach (array_merge([
            'name' => 'Test Courier', 'status' => 1,
            'over_head' => 1, 'over_head_intl' => 1,
            'comission' => 100, 'comission_document' => 80,
            'comission_intl' => 75, 'comission_document_intl' => 70,
            'service_fee' => 0, 'service_fee_intl' => 10,
            'start_time' => '00:00', 'end_time' => '16:00',
            'normal_days' => 1, 'non_normal_days' => 2, 'normal_days_intl' => 2, 'non_normal_days_intl' => 2,
        ], $overrides) as $k => $v) {
            $c->$k = $v;
        }
        $c->save();

        return $c;
    }

    private function order(array $attrs = [], array $meta = []): OrderModel
    {
        $o = new OrderModel;
        foreach (array_merge([
            'customer_id' => 0, 'vat' => 0, 'total' => 0, 'subtotal' => 0, 'courier_quote' => 0,
            'comission' => 0, 'over_head' => 0, 'service_fee' => 0, 'courier_vat' => 0,
            'payment_status' => 0, 'status' => 'pending', 'courier' => 0,
        ], $attrs) as $k => $v) {
            $o->$k = $v;
        }
        $o->save();

        foreach (array_merge([
            'sender_name' => 'Sam Sender', 'sender_phone' => '0501112222', 'sender_email' => 'sam@example.com',
            'sender_country' => 'United Arab Emirates', 'sender_state' => 'Dubai',
            'reciever_name' => 'Rita Receiver', 'reciever_phone' => '0503334444', 'reciever_email' => 'rita@example.com',
            'reciever_country' => 'United Arab Emirates', 'reciever_state' => 'Abu Dhabi',
        ], $meta) as $k => $v) {
            $m = new OrderMetaModel;
            $m->order_id = $o->id;
            $m->key = $k;
            $m->value = $v;
            $m->save();
        }

        return $o;
    }

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'status' => 'processing', 'payment_status' => '0', 'courier' => '0',
            'subtotal' => '0', 'vat' => '0', 'service_fee' => '0', 'over_head' => '0',
            'courier_vat' => '0', 'courier_quote' => '0', 'comission' => '0',
            'sender_country' => 'United Arab Emirates', 'reciever_country' => 'United Arab Emirates',
        ], $overrides);
    }

    // ---- pricing rules (match historical data) ----

    public function test_pricing_service_reproduces_historical_orders(): void
    {
        // Order 1339 (Posta+, 100%): subtotal 24.77, vat 0.6192 → total 25.39, commission ≈ 12.38
        $this->assertSame(25.39, OrderPricing::total(24.77, 0.6192, 0));
        $this->assertEqualsWithDelta(12.384, OrderPricing::commission(24.77, 100), 0.01);
        // Order 1340 (Emirates Post, 80%): subtotal 23.4 → commission 10.4
        $this->assertSame(10.4, OrderPricing::commission(23.4, 80));
        // Order 1313 (Aramex, 150%): subtotal 70.88 → commission 42.525
        $this->assertEqualsWithDelta(42.525, OrderPricing::commission(70.88, 150), 0.01);
        // Order 1 had a service fee: 13.65 + 0 + 6 = 19.65
        $this->assertSame(19.65, OrderPricing::total(13.65, 0, 6));
        $this->assertSame(0.0, OrderPricing::commission(0, 100));
    }

    public function test_international_detection(): void
    {
        $this->assertFalse(OrderPricing::isInternational('United Arab Emirates', 'ARE'));
        $this->assertFalse(OrderPricing::isInternational('', null));
        $this->assertTrue(OrderPricing::isInternational('United Arab Emirates', 'LBN'));
        $this->assertTrue(OrderPricing::isInternational('Saudi Arabia', 'ARE'));
    }

    // ---- permissions ----

    public function test_guests_are_redirected_from_admin_order_pages(): void
    {
        $order = $this->order();
        $this->get(route('admin.order.index'))->assertRedirect('/login');
        $this->get(route('admin.view.order', $order->id))->assertRedirect('/login');
        $this->post(route('admin.order.update', $order->id), $this->payload())->assertRedirect('/login');
        $this->post(route('admin.settle.courier'), ['order_id' => [$order->id]])->assertRedirect('/login');
        $this->assertSame('pending', $order->fresh()->status);
    }

    // ---- saving an order ----

    public function test_backend_computes_total_and_ignores_a_posted_total(): void
    {
        $courier = $this->courier();
        $order = $this->order();

        $this->actingAs($this->admin())
            ->post(route('admin.order.update', $order->id), $this->payload([
                'courier' => (string) $courier->id,
                'subtotal' => '50', 'vat' => '1.25', 'service_fee' => '2',
                'total' => '9999', // tampered — must be ignored
                'quote_same_as_subtotal' => '1',
                'commission_mode' => 'auto', 'commission_basis' => 'parcel',
            ]))
            ->assertRedirect(route('admin.view.order', $order->id))
            ->assertSessionHas('class', 'alert-success');

        $order->refresh();
        $this->assertEquals(53.25, $order->total);
        $this->assertEquals(50, $order->courier_quote);
        $this->assertEquals(25, $order->comission); // 50 × 100 / 200
        $this->assertSame('processing', $order->status);
    }

    public function test_auto_commission_uses_international_and_document_rates(): void
    {
        $courier = $this->courier();
        $order = $this->order([], ['reciever_country' => 'LBN']);

        $this->actingAs($this->admin())
            ->post(route('admin.order.update', $order->id), $this->payload([
                'courier' => (string) $courier->id, 'subtotal' => '170',
                'reciever_country' => 'LBN',
                'commission_mode' => 'auto', 'commission_basis' => 'document',
                'quote_same_as_subtotal' => '1',
            ]));

        // intl document rate 70% → 170 × 70 / 170 = 70
        $this->assertEquals(70, $order->fresh()->comission);
    }

    public function test_manual_values_are_kept_when_auto_modes_are_off(): void
    {
        $courier = $this->courier();
        $order = $this->order();

        $this->actingAs($this->admin())
            ->post(route('admin.order.update', $order->id), $this->payload([
                'courier' => (string) $courier->id, 'subtotal' => '40',
                'courier_quote' => '30', 'comission' => '7.5', 'commission_mode' => 'manual',
            ]));

        $order->refresh();
        $this->assertEquals(30, $order->courier_quote);
        $this->assertEquals(7.5, $order->comission);
        $this->assertEquals(40, $order->total);
    }

    public function test_auto_commission_without_courier_falls_back_to_posted_value(): void
    {
        $order = $this->order();

        $this->actingAs($this->admin())
            ->post(route('admin.order.update', $order->id), $this->payload([
                'subtotal' => '40', 'comission' => '5', 'commission_mode' => 'auto',
            ]));

        $this->assertEquals(5, $order->fresh()->comission);
    }

    public function test_validation_rejects_bad_input_and_saves_nothing(): void
    {
        $order = $this->order();

        $this->actingAs($this->admin())
            ->from(route('admin.view.order', $order->id))
            ->post(route('admin.order.update', $order->id), $this->payload([
                'subtotal' => '-5', 'status' => 'shipped', 'courier' => '987654', 'reciever_email' => 'not-an-email',
            ]))
            ->assertRedirect(route('admin.view.order', $order->id))
            ->assertSessionHasErrors(['subtotal', 'status', 'courier', 'reciever_email']);

        $this->assertSame('pending', $order->fresh()->status);
    }

    public function test_package_dimensions_are_saved_and_scoped_to_the_order(): void
    {
        $order = $this->order();
        $other = $this->order();
        $mine = new OrderDimensionModel;
        $mine->forceFill(['order_id' => $order->id, 'qty' => 1, 'length' => 10, 'width' => 10, 'height' => 10, 'weight' => 1])->save();
        $theirs = new OrderDimensionModel;
        $theirs->forceFill(['order_id' => $other->id, 'qty' => 1, 'length' => 5, 'width' => 5, 'height' => 5, 'weight' => 1])->save();

        $this->actingAs($this->admin())
            ->post(route('admin.order.update', $order->id), $this->payload([
                'dimension_id' => [$mine->id, $theirs->id],
                'dimension_qty' => ['2', '9'], 'dimension_length' => ['30', '99'],
                'dimension_width' => ['20', '99'], 'dimension_height' => ['15', '99'], 'dimension_weight' => ['4', '99'],
            ]))
            ->assertSessionHasNoErrors();

        $this->assertEquals([2, 30, 20, 15, 4], array_values($mine->fresh()->only(['qty', 'length', 'width', 'height', 'weight'])));
        $this->assertEquals(5, $theirs->fresh()->length, 'Another order\'s package must not be editable through this form.');
    }

    public function test_changes_are_written_to_the_activity_log(): void
    {
        $order = $this->order();

        $this->actingAs($this->admin())
            ->post(route('admin.order.update', $order->id), $this->payload(['subtotal' => '20', 'reciever_state' => 'Sharjah']));

        $log = LogModel::where('mess', 'like', 'Order #'.$order->id.':%')->latest('id')->first();
        $this->assertNotNull($log);
        $this->assertStringContainsString('status pending → processing', $log->mess);
        $this->assertStringContainsString('total 0.00 → 20.00', $log->mess);
        $this->assertStringContainsString('receiver state', $log->mess);
    }

    // ---- settlement ----

    public function test_settle_selected_orders_skips_cancelled_settled_and_unpriced(): void
    {
        $priced = $this->order(['courier_quote' => 20, 'courier_vat' => 1, 'subtotal' => 20, 'status' => 'completed']);
        $cancelled = $this->order(['courier_quote' => 20, 'courier_vat' => 1, 'status' => 'cancelled']);
        $unpriced = $this->order();
        $already = $this->order(['courier_quote' => 10, 'order_settled' => 10, 'status' => 'completed']);

        $this->actingAs($this->admin())
            ->post(route('admin.settle.courier'), ['order_id' => [$priced->id, $cancelled->id, $unpriced->id, $already->id]])
            ->assertSessionHas('class', 'alert-success');

        $this->assertEquals(21, $priced->fresh()->order_settled);
        $this->assertEquals(0, $cancelled->fresh()->order_settled);
        $this->assertEquals(0, $unpriced->fresh()->order_settled);
        $this->assertEquals(10, $already->fresh()->order_settled);
    }

    public function test_settle_all_in_filtered_view_only_touches_matching_orders(): void
    {
        $a = $this->courier(['name' => 'A']);
        $b = $this->courier(['name' => 'B']);
        $mine = $this->order(['courier' => $a->id, 'courier_quote' => 15, 'status' => 'completed']);
        $notMine = $this->order(['courier' => $b->id, 'courier_quote' => 15, 'status' => 'completed']);

        $this->actingAs($this->admin())
            ->post(route('admin.settle.courier'), ['apply_to' => 'filtered', 'courier' => (string) $a->id]);

        $this->assertEquals(15, $mine->fresh()->order_settled);
        $this->assertEquals(0, $notMine->fresh()->order_settled);
    }

    // ---- list / search ----

    public function test_orders_list_filters_and_searches(): void
    {
        $admin = $this->admin();
        $match = $this->order(['status' => 'pending'], ['sender_name' => 'Zebulon Uniquename']);
        $other = $this->order(['status' => 'pending'], ['sender_name' => 'Somebody Else']);

        $this->actingAs($admin)->get(route('admin.order.index', ['q' => 'Uniquename']))
            ->assertOk()
            ->assertSee('#'.$match->id)
            ->assertDontSee('>#'.$other->id.'<', false);

        $this->actingAs($admin)->get(route('admin.order.index', ['q' => '#'.$other->id]))
            ->assertOk()->assertSee('Somebody Else');

        $this->actingAs($admin)->get(route('admin.order.index', ['status' => 'cancelled', 'courier' => 'unassigned', 'payment' => 'unpaid', 'settled' => 'no', 's_date' => '2020-01-01', 'e_date' => '2030-01-01']))
            ->assertOk()->assertSee('No orders match these filters.');
    }

    public function test_legacy_search_url_redirects_to_filtered_list(): void
    {
        $this->actingAs($this->admin())
            ->get(route('admin.search.orders', ['s_date' => '2025-01-01', 'e_date' => '2025-01-31', 'courier' => '0']))
            ->assertRedirect(route('admin.order.index', ['s_date' => '2025-01-01', 'e_date' => '2025-01-31']));
    }

    public function test_order_page_renders_with_pricing_tools(): void
    {
        $courier = $this->courier(['name' => 'Speedy']);
        $order = $this->order(['courier' => $courier->id, 'subtotal' => 24.77, 'courier_quote' => 24.77, 'comission' => 12.39, 'total' => 25.39, 'vat' => 0.62]);

        $this->actingAs($this->admin())->get(route('admin.view.order', $order->id))
            ->assertOk()
            ->assertSee('Order #'.$order->id)
            ->assertSee('Total payable')
            ->assertSee('Rita Receiver')
            ->assertSee('"comission":100', false);
    }

    public function test_missing_order_returns_404(): void
    {
        $this->actingAs($this->admin())->get(route('admin.view.order', 99999999))->assertNotFound();
    }
}
