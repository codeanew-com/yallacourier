<?php

namespace Tests\Feature;

use App\Models\CourierModel;
use App\Models\FaqModel;
use App\Models\FileModel;
use App\Models\PageModel;
use App\Models\ReviewModel;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AdminContentTest extends TestCase
{
    use DatabaseTransactions;

    private function admin(): User
    {
        return User::create(['name' => 'Admin', 'email' => 'a_'.uniqid().'@example.com', 'password' => bcrypt('x12345678')]);
    }

    private function pageData(array $o = []): array
    {
        return array_merge(['title' => 'Same Day Delivery', 'meta_description' => '<p>Fast parcels</p>', 'status' => '1'], $o);
    }

    public function test_admin_screens_require_login(): void
    {
        foreach (['/admin', '/admin/pages', '/admin/faq', '/admin/review', '/admin/couriers', '/admin/customers', '/admin/business-leads'] as $url) {
            $this->get($url)->assertRedirect('/login');
        }
    }

    public function test_dashboard_renders(): void
    {
        $this->actingAs($this->admin())->get('/admin')->assertOk()->assertSee('Pending requests')->assertSee('Owed to couriers');
    }

    // ---- pages ----

    public function test_page_defaults_slug_seo_title_and_canonical_from_title(): void
    {
        $this->actingAs($this->admin())->post(route('admin-pages.store'), $this->pageData())->assertRedirect(route('admin-pages.index'));

        $page = PageModel::where('title', 'Same Day Delivery')->latest('id')->first();
        $this->assertSame('same-day-delivery', $page->slug);
        $this->assertSame('Same Day Delivery', $page->page_title);
        $this->assertSame(rtrim(config('app.public_url'), '/').'/same-day-delivery', $page->page_cron_url, 'Defaults to the live URL, not the dev machine.');
        $this->assertSame('Fast parcels', $page->meta_description, 'HTML must not end up in the meta description.');
        $this->assertSame('index,follow', $page->visibility);
    }

    public function test_page_update_cannot_take_another_pages_slug(): void
    {
        $admin = $this->admin();
        $this->actingAs($admin)->post(route('admin-pages.store'), $this->pageData(['title' => 'Alpha Unique Page']));
        $this->actingAs($admin)->post(route('admin-pages.store'), $this->pageData(['title' => 'Beta Unique Page']));
        $beta = PageModel::where('slug', 'beta-unique-page')->first();

        $this->actingAs($admin)->patch(route('admin-pages.update', $beta->id), $this->pageData(['title' => 'Beta Unique Page', 'slug' => 'alpha-unique-page']))
            ->assertSessionHasErrors('slug');
        $this->assertSame('beta-unique-page', $beta->fresh()->slug);

        // Saving a page with its own slug is fine.
        $this->actingAs($admin)->patch(route('admin-pages.update', $beta->id), $this->pageData(['title' => 'Beta Renamed', 'slug' => 'beta-unique-page']))
            ->assertSessionHasNoErrors();
        $this->assertSame('Beta Renamed', $beta->fresh()->title);
    }

    public function test_built_in_pages_cannot_be_deleted_but_custom_pages_can(): void
    {
        $admin = $this->admin();
        $home = new PageModel;
        $home->forceFill(['id' => 1, 'title' => 'Home', 'slug' => 'home-test-'.uniqid(), 'visibility' => 'index,follow', 'status' => 1, 'added_by' => $admin->id]);
        if (! PageModel::find(1)) {
            $home->save();
        }
        $this->actingAs($admin)->delete(route('admin-pages.destroy', 1))->assertSessionHas('class', 'alert-warning');
        $this->assertNotNull(PageModel::find(1));

        $this->actingAs($admin)->post(route('admin-pages.store'), $this->pageData(['title' => 'Disposable Page']));
        $custom = PageModel::where('slug', 'disposable-page')->first();
        $this->actingAs($admin)->delete(route('admin-pages.destroy', $custom->id))->assertSessionHas('class', 'alert-success');
        $this->assertNull(PageModel::find($custom->id));
    }

    public function test_page_forms_render(): void
    {
        $admin = $this->admin();
        $this->actingAs($admin)->get(route('admin-pages.create'))->assertOk()->assertSee('data-slug-source', false);
        $this->actingAs($admin)->get(route('admin-pages.index'))->assertOk();
    }

    // ---- FAQ / reviews ----

    public function test_faq_update_ignores_columns_outside_the_form(): void
    {
        $faq = FaqModel::create(['question' => 'Q?', 'answer' => 'A', 'show_on_home' => 0, 'status' => 1]);
        $createdAt = $faq->created_at->toDateTimeString();

        $this->actingAs($this->admin())->patch(route('admin-faq.update', $faq->id), [
            'question' => 'New Q?', 'answer' => 'New A', 'show_on_home' => '1', 'status' => '1',
            'created_at' => '2001-01-01 00:00:00', // not editable — must be ignored
        ])->assertRedirect(route('admin-faq.index'));

        $faq->refresh();
        $this->assertSame('New Q?', $faq->question);
        $this->assertSame($createdAt, $faq->created_at->toDateTimeString());
    }

    public function test_faq_save_and_add_another_returns_to_form(): void
    {
        $this->actingAs($this->admin())->post(route('admin-faq.store'), ['question' => 'Another?', 'answer' => 'Yes', 'show_on_home' => '0', 'status' => '1', 'after' => 'new'])
            ->assertRedirect(route('admin-faq.create'));
    }

    public function test_review_rejects_non_images_and_renames_uploads(): void
    {
        $admin = $this->admin();
        $base = ['review' => 'Great', 'author_name' => 'Rania', 'author_designation' => 'Shop owner', 'show_on_home' => '1', 'status' => '1'];

        $this->actingAs($admin)->post(route('admin-review.store'), $base + ['author_image' => UploadedFile::fake()->create('evil.php', 1, 'application/x-php')])
            ->assertSessionHasErrors('author_image');

        $this->actingAs($admin)->post(route('admin-review.store'), $base + ['author_image' => UploadedFile::fake()->createWithContent('my photo.png', base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg=='))])
            ->assertSessionHasNoErrors();
        $rev = ReviewModel::where('author_name', 'Rania')->latest('id')->first();
        $file = FileModel::where('ref_point', 'author_image')->where('ref_id', $rev->id)->first();
        $this->assertNotNull($file);
        $this->assertNotSame('my photo.png', $file->name, 'Uploads must not keep the client-supplied filename.');
        $this->assertFileExists(public_path($file->path.'/'.$file->name));
        @unlink(public_path($file->path.'/'.$file->name));
        @rmdir(public_path($file->path));
    }

    // ---- couriers ----

    private function courierData(array $o = []): array
    {
        return array_merge([
            'name' => 'Test Express', 'status' => '1', 'start_time' => '09:00', 'end_time' => '16:00',
            'over_head' => '1', 'service_fee' => '0', 'comission' => '100', 'comission_document' => '80',
            'normal_days' => '1', 'non_normal_days' => '2', 'over_head_intl' => '1', 'service_fee_intl' => '10',
            'comission_intl' => '75', 'comission_document_intl' => '70', 'normal_days_intl' => '2', 'non_normal_days_intl' => '3', 'saudi_tax' => '15',
        ], $o);
    }

    public function test_courier_can_be_created_with_all_rates(): void
    {
        $this->actingAs($this->admin())->post(route('admin-couriers.store'), $this->courierData())->assertRedirect(route('admin-couriers.index'));
        $c = CourierModel::where('name', 'Test Express')->latest('id')->first();
        $this->assertEquals(75, $c->comission_intl);
        $this->assertEquals(15, $c->saudi_tax);
    }

    public function test_courier_validation_rejects_bad_rates_and_times(): void
    {
        $this->actingAs($this->admin())->post(route('admin-couriers.store'), $this->courierData(['comission' => '-5', 'end_time' => '08:00']))
            ->assertSessionHasErrors(['comission', 'end_time']);
    }

    public function test_courier_deactivate_and_activate_actually_save(): void
    {
        $admin = $this->admin();
        $this->actingAs($admin)->post(route('admin-couriers.store'), $this->courierData(['name' => 'Toggle Co']));
        $c = CourierModel::where('name', 'Toggle Co')->first();

        $this->actingAs($admin)->delete(route('admin-couriers.destroy', $c->id));
        $this->assertEquals(0, $c->fresh()->status);

        $this->actingAs($admin)->patch(route('admin-couriers.update', $c->id), ['toggle_status' => '1']);
        $this->assertEquals(1, $c->fresh()->status);
        $this->assertEquals(100, $c->fresh()->comission, 'Toggling must not touch the rates.');
    }

    // ---- leads / SEO ----

    public function test_robots_rejects_empty_content_without_claiming_success(): void
    {
        $before = file_get_contents(public_path('robots.txt'));
        $this->actingAs($this->admin())->post(route('admin.save.txtfile'), ['content' => '   '])->assertSessionHas('class', 'alert-warning');
        $this->assertSame($before, file_get_contents(public_path('robots.txt')));
    }

    public function test_sitemap_rejects_invalid_xml(): void
    {
        $before = file_get_contents(public_path('sitemap.xml'));
        $this->actingAs($this->admin())->post(route('admin.save.sitemap'), ['content' => '<urlset><url>'])->assertSessionHas('class', 'alert-danger');
        $this->assertSame($before, file_get_contents(public_path('sitemap.xml')));
    }
}
