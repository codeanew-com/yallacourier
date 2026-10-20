<?php

namespace Tests\Feature;

use App\Models\CustomerModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ContactNumberMigrationTest extends TestCase
{
    use DatabaseTransactions;

    private function runMigration(): void
    {
        $m = require database_path('migrations/2026_10_20_050000_replace_old_contact_numbers_in_site_content.php');
        $m->up();
    }

    public function test_every_old_format_becomes_the_new_number_and_customer_data_is_untouched(): void
    {
        $samples = [
            'Send a Parcel To Qatar By Courier | WhatsApp us 056 864 9187' => 'Send a Parcel To Qatar By Courier | WhatsApp us 052 660 7133',
            '<a href="https://wa.me/971585800119">WhatsApp Us</a>' => '<a href="https://wa.me/971526607133">WhatsApp Us</a>',
            'https://api.whatsapp.com/send/?phone=971585800119&text' => 'https://api.whatsapp.com/send/?phone=971526607133&text',
            '<a href="tel:+9710586611932">+971 058 661 1932 </a>' => '<a href="tel:+971526607133">+971 52 660 7133 </a>',
            '<a href="tel:+971058661193">Call</a>' => '<a href="tel:+971526607133">Call</a>',
            'Call 058 661 1932 or 0585800119' => 'Call 052 660 7133 or 052 660 7133',
            'Already new: 052 660 7133' => 'Already new: 052 660 7133',
        ];
        $ids = [];
        foreach (array_keys($samples) as $i => $text) {
            $ids[$text] = DB::table('pages_meta')->insertGetId(['ref_id' => 999000 + $i, 'ref_key' => 'phone_test', 'value' => $text]);
        }
        $customer = new CustomerModel;
        $customer->forceFill(['name' => 'C', 'email' => 'c_'.uniqid().'@example.com', 'password' => 'x12345678a', 'balance' => 0, 'phone' => '058 661 1932'])->save();

        $this->runMigration();
        $this->runMigration(); // idempotent

        foreach ($samples as $before => $after) {
            $this->assertSame($after, DB::table('pages_meta')->where('id', $ids[$before])->value('value'), "Failed for: $before");
        }
        $this->assertSame('058 661 1932', $customer->fresh()->phone, 'Customer data must never be rewritten.');
    }
}
