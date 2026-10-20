<?php

namespace Tests\Feature;

use App\Models\CustomerModel;
use App\Models\OrderModel;
use App\Models\OrderPackagesModel;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class OrderLabelDownloadTest extends TestCase
{
    use DatabaseTransactions;

    private function makePackage(int $customerId): OrderPackagesModel
    {
        Storage::fake('private');

        $order = new OrderModel;
        $order->customer_id = $customerId;
        $order->vat = 0;
        $order->total = 0;
        $order->subtotal = 0;
        $order->payment_status = 0;
        $order->courier = 1;
        $order->save();

        $label = 'pdf/TESTAWB123/TESTAWB123.pdf';
        Storage::disk('private')->put($label, 'fake pdf content');

        $package = new OrderPackagesModel;
        $package->order_id = $order->id;
        $package->awb_number = 'TESTAWB123';
        $package->awb_status = 'Created';
        $package->awb_label = $label;
        $package->save();

        return $package;
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

    public function test_guest_cannot_download_label(): void
    {
        $package = $this->makePackage(0);

        $response = $this->get('/order-package/'.$package->id.'/label');

        $response->assertForbidden();
    }

    public function test_admin_can_download_any_label(): void
    {
        $admin = User::factory()->create();
        $package = $this->makePackage(0);

        $response = $this->actingAs($admin, 'web')->get('/order-package/'.$package->id.'/label');

        $response->assertOk();
    }

    public function test_owning_customer_can_download_label(): void
    {
        $customer = $this->makeCustomer();
        $package = $this->makePackage($customer->id);

        $response = $this->actingAs($customer, 'customers')->get('/order-package/'.$package->id.'/label');

        $response->assertOk();
    }

    public function test_non_owning_customer_cannot_download_label(): void
    {
        $customer = $this->makeCustomer();
        $package = $this->makePackage(0);

        $response = $this->actingAs($customer, 'customers')->get('/order-package/'.$package->id.'/label');

        $response->assertForbidden();
    }
}
