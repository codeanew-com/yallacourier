<?php

namespace Tests\Feature;

use App\Models\CountriesModel;
use App\Models\FileModel;
use App\Models\LogModel;
use App\Models\PageMetaModel;
use App\Models\User;
use App\Services\Content\PageMetaService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Tests\TestCase;

/** Section content of the built-in pages (admin "Page content") and country page images. */
class AdminPageContentTest extends TestCase
{
    use DatabaseTransactions;

    /** Fake page ids far above real ones, so no live content or upload folder is touched. */
    private const PAGE = 990001;

    private function admin(): User
    {
        return User::create(['name' => 'Admin', 'email' => 'a_'.uniqid().'@example.com', 'password' => bcrypt('x12345678')]);
    }

    protected function tearDown(): void
    {
        File::deleteDirectory(public_path('uploads/pagemeta/'.self::PAGE));
        parent::tearDown();
    }

    public function test_each_built_in_page_opens_its_own_editor(): void
    {
        $admin = $this->admin();
        $this->actingAs($admin)->get('/admin/page-meta/1')->assertOk()->assertViewIs('admin.pagemeta.home.index')->assertViewHas('id', '1');
        $this->actingAs($admin)->get('/admin/page-meta/13')->assertOk()->assertViewIs('admin.pagemeta.qatar.index');
        // Pages without their own editor fall back to the UAE parcel delivery one.
        $this->actingAs($admin)->get('/admin/page-meta/'.self::PAGE)->assertOk()->assertViewIs('admin.pagemeta.uaeparceldelivery.index');
    }

    public function test_text_fields_are_upserted_and_empty_ones_skipped(): void
    {
        $admin = $this->admin();
        PageMetaModel::insert(['ref_id' => self::PAGE, 'ref_key' => 'banner_title', 'value' => 'Old', 'created_at' => now(), 'updated_at' => now()]);

        $this->actingAs($admin)->from('/admin/page-meta/'.self::PAGE)->post('/admin/page-meta-store', [
            'page_id' => self::PAGE,
            'page_meta' => ['banner_title' => 'New title', 'sec_one_title' => 'Section one', 'sec_two_title' => ''],
        ])->assertRedirect('/admin/page-meta/'.self::PAGE)->assertSessionHas('msg', 'Setting Updated Successfully');

        $this->assertSame('New title', PageMetaModel::where('ref_id', self::PAGE)->where('ref_key', 'banner_title')->value('value'));
        $this->assertSame(1, PageMetaModel::where('ref_id', self::PAGE)->where('ref_key', 'banner_title')->count());
        $this->assertSame('Section one', PageMetaModel::where('ref_id', self::PAGE)->where('ref_key', 'sec_one_title')->value('value'));
        $this->assertFalse(PageMetaModel::where('ref_id', self::PAGE)->where('ref_key', 'sec_two_title')->exists());
        $this->assertSame(2, LogModel::where('mess', 'Page Meta Changed For Page : '.self::PAGE)->count());
    }

    public function test_only_the_pages_own_image_slots_are_saved_and_replace_the_old_image(): void
    {
        $admin = $this->admin();
        $post = fn (array $files) => $this->actingAs($admin)->post('/admin/page-meta-store', ['page_id' => self::PAGE] + $files);

        // An unknown page id uses the default (UAE parcel delivery) slots: home_banner_background is one,
        // landing_banner_background (a country-page slot) is not.
        $post([
            'home_banner_background' => UploadedFile::fake()->create('a.jpg', 10, 'image/jpeg'),
            'landing_banner_background' => UploadedFile::fake()->create('b.jpg', 10, 'image/jpeg'),
        ])->assertRedirect();

        $first = FileModel::where('ref_id', self::PAGE)->where('ref_point', 'home_banner_background')->firstOrFail();
        $this->assertFileExists(public_path($first->path.'/'.$first->name));
        $this->assertStringStartsWith('uploads/pagemeta/'.self::PAGE.'/', $first->path);
        $this->assertFalse(FileModel::where('ref_id', self::PAGE)->where('ref_point', 'landing_banner_background')->exists());
        $this->assertSame(1, LogModel::where('mess', 'Page Meta Changed (File) For Page : '.self::PAGE)->count());

        // Uploading again replaces the old image: file removed, record soft-deleted.
        $post(['home_banner_background' => UploadedFile::fake()->create('c.png', 10, 'image/png')])->assertRedirect();
        $this->assertFileDoesNotExist(public_path($first->path.'/'.$first->name));
        $this->assertSoftDeleted('files', ['id' => $first->id]);
        $this->assertSame(1, FileModel::where('ref_id', self::PAGE)->where('ref_point', 'home_banner_background')->count());
    }

    public function test_image_slot_table_matches_the_editors(): void
    {
        $this->assertContains('section_7_image_7', PageMetaService::imageSlotsFor('13'));
        $this->assertContains('section_6_image', PageMetaService::imageSlotsFor(1));
        $this->assertSame(PageMetaService::IMAGE_SLOTS[4], PageMetaService::imageSlotsFor('not-a-page'));
        $this->assertSame(PageMetaService::IMAGE_SLOTS[4], PageMetaService::imageSlotsFor(null));
    }

    public function test_country_page_images_are_stored_and_replaced(): void
    {
        $admin = $this->admin();
        $data = ['title' => 'Testland '.uniqid()];
        foreach (['banner_title', 'sec_one_title', 'sec_one_content', 'sec_two_title', 'sec_two_subheading_1', 'sec_two_subheading_2', 'sec_two_subheading_3', 'sec_two_subheading_4',
            'sec_three_title', 'sec_three_subheading_1', 'sec_three_subheading_2', 'sec_three_subheading_3', 'sec_three_subheading_4', 'sec_three_content_1', 'sec_three_content_2',
            'sec_three_content_3', 'sec_three_content_4', 'sec_four_title', 'sec_four_subheading_1', 'sec_four_subheading_2', 'sec_four_subheading_3', 'sec_four_content_1',
            'sec_four_content_2', 'sec_four_content_3', 'sec_five_title', 'sec_six_title', 'sec_seven_title', 'sec_seven_content'] as $f) {
            $data[$f] = 'x';
        }

        $this->actingAs($admin)->post('/admin/country', $data + ['section_one_image' => UploadedFile::fake()->create('one.jpg', 10, 'image/jpeg')])
            ->assertRedirect(route('admin-country.index'));
        $country = CountriesModel::where('title', $data['title'])->firstOrFail();
        $this->assertSame(Str::slug($data['title']), $country->slug);
        $old = FileModel::where('ref_id', $country->id)->where('ref_point', 'section_one_image')->firstOrFail();

        // Edit keeps the existing slug when one is posted, and replaces the image in that slot.
        $this->actingAs($admin)->put('/admin/country/'.$country->id, $data + ['slug' => 'Kept-Slug-'.$country->id, 'section_one_image' => UploadedFile::fake()->create('two.jpg', 10, 'image/jpeg')])
            ->assertRedirect(route('admin-country.index'));
        $this->assertSame('Kept-Slug-'.$country->id, $country->fresh()->slug);
        $this->assertSoftDeleted('files', ['id' => $old->id]);
        $new = FileModel::where('ref_id', $country->id)->where('ref_point', 'section_one_image')->firstOrFail();
        $this->assertFileExists(public_path($new->path.'/'.$new->name));

        @unlink(public_path($new->path.'/'.$new->name));
    }

    public function test_country_form_requires_its_sections(): void
    {
        $this->actingAs($this->admin())->from('/admin/country/create')->post('/admin/country', ['title' => 'Only a title'])
            ->assertRedirect('/admin/country/create')
            ->assertSessionHasErrors(['banner_title', 'sec_seven_content']);
    }
}
