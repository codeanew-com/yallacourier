<?php

namespace Tests\Feature;

use App\Models\PageModel;
use App\Models\User;
use App\Services\Content\SitemapGenerator;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SeoAndFaviconTest extends TestCase
{
    use DatabaseTransactions;

    private string $sitemapBackup;

    private string $robotsBackup;

    protected function setUp(): void
    {
        parent::setUp();
        config(['app.public_url' => 'https://yallacourier.com']);
        $this->sitemapBackup = (string) @file_get_contents(public_path('sitemap.xml'));
        $this->robotsBackup = (string) @file_get_contents(public_path('robots.txt'));
    }

    protected function tearDown(): void
    {
        file_put_contents(public_path('sitemap.xml'), $this->sitemapBackup);
        file_put_contents(public_path('robots.txt'), $this->robotsBackup);
        parent::tearDown();
    }

    private function page(array $o): PageModel
    {
        $p = new PageModel;
        $p->forceFill(array_merge(['title' => 'T', 'visibility' => 'index,follow', 'status' => 1, 'added_by' => 1, 'has_meta' => 0], $o))->save();

        return $p;
    }

    public function test_canonical_ignores_off_site_and_wrong_case_values(): void
    {
        $base = ['slug' => 'seo-'.uniqid()];
        $this->assertSame('https://yallacourier.com/'.$base['slug'], $this->page($base + ['page_cron_url' => 'http://localhost/yalla-courier/public'])->canonicalUrl());
        $this->assertSame('https://yallacourier.com/'.$base['slug'], (new PageModel)->forceFill($base + ['id' => 99999, 'page_cron_url' => 'https://yalla-courier.test/'])->canonicalUrl());
        $this->assertSame('https://yallacourier.com/'.$base['slug'], (new PageModel)->forceFill($base + ['id' => 99998, 'page_cron_url' => 'https://yallacourier.com/'.strtoupper($base['slug'])])->canonicalUrl());
        $this->assertSame('https://yallacourier.com/'.$base['slug'], (new PageModel)->forceFill($base + ['id' => 99997, 'page_cron_url' => ''])->canonicalUrl());
        // A deliberate canonical to another page on the live site is respected.
        $this->assertSame('https://yallacourier.com/about', (new PageModel)->forceFill($base + ['id' => 99996, 'page_cron_url' => 'https://yallacourier.com/about'])->canonicalUrl());
        // Home is "/", and /home counts as the same page.
        $this->assertSame('https://yallacourier.com/', (new PageModel)->forceFill(['id' => 1, 'slug' => 'home', 'page_cron_url' => 'https://yallacourier.com/home'])->canonicalUrl());
    }

    public function test_sitemap_lists_only_indexable_canonical_live_urls_once(): void
    {
        $ok = $this->page(['slug' => 'seo-ok-'.uniqid(), 'page_cron_url' => 'http://localhost/whatever']);
        $hidden = $this->page(['slug' => 'seo-hidden-'.uniqid(), 'visibility' => 'noindex,nofollow']);
        $draft = $this->page(['slug' => 'seo-draft-'.uniqid(), 'status' => 0]);
        $alias = $this->page(['slug' => 'seo-alias-'.uniqid(), 'page_cron_url' => 'https://yallacourier.com/about']);
        $dupe = $this->page(['slug' => $ok->slug]);

        $result = app(SitemapGenerator::class)->generate();
        $xml = file_get_contents(public_path('sitemap.xml'));

        $this->assertNotFalse(simplexml_load_string($xml));
        $this->assertStringContainsString('<loc>https://yallacourier.com/'.$ok->slug.'</loc>', $xml);
        $this->assertSame(1, substr_count($xml, '/'.$ok->slug.'</loc>'));
        foreach ([$hidden, $draft, $alias] as $p) {
            $this->assertStringNotContainsString('/'.$p->slug.'<', $xml);
        }
        $this->assertStringNotContainsString('127.0.0.1', $xml);
        $this->assertStringNotContainsString('localhost', $xml);
        $this->assertStringNotContainsString('/home</loc>', $xml);
        $this->assertSame(count($result['urls']), substr_count($xml, '<loc>'));
        $this->assertStringContainsString('Sitemap: https://yallacourier.com/sitemap.xml', file_get_contents(public_path('robots.txt')));
    }

    public function test_robots_sitemap_line_is_not_duplicated(): void
    {
        file_put_contents(public_path('robots.txt'), "User-agent: *\nDisallow:\n\nSitemap: https://yallacourier.com/sitemap.xml\n");
        $this->assertFalse(app(SitemapGenerator::class)->ensureRobotsReference());
        $this->assertSame(1, substr_count(file_get_contents(public_path('robots.txt')), 'Sitemap:'));
    }

    public function test_admin_generate_button_and_public_sitemap_url(): void
    {
        $admin = User::create(['name' => 'A', 'email' => 'a_'.uniqid().'@example.com', 'password' => bcrypt('x12345678')]);
        $this->actingAs($admin)->get(route('admin.generate.sitemap'))->assertRedirect()->assertSessionHas('class', 'alert-success');
        $this->assertFileExists(public_path('sitemap.xml'));
    }

    public function test_page_form_rejects_off_site_canonical(): void
    {
        $admin = User::create(['name' => 'A', 'email' => 'a_'.uniqid().'@example.com', 'password' => bcrypt('x12345678')]);
        $this->actingAs($admin)->post(route('admin-pages.store'), ['title' => 'Canon Test', 'meta_description' => 'x', 'status' => '1', 'page_cron_url' => 'http://localhost/yalla'])
            ->assertSessionHasErrors('page_cron_url');
        $this->actingAs($admin)->post(route('admin-pages.store'), ['title' => 'Canon Test Two', 'meta_description' => 'x', 'status' => '1'])
            ->assertSessionHasNoErrors();
        $this->assertSame('https://yallacourier.com/canon-test-two', PageModel::where('slug', 'canon-test-two')->value('page_cron_url'));
    }

    public function test_every_layout_declares_the_favicon_set_and_files_exist(): void
    {
        foreach (['favicon.ico', 'favicon-32x32.png', 'apple-touch-icon.png', 'icon-192.png', 'icon-512.png', 'site.webmanifest'] as $f) {
            $this->assertFileExists(public_path($f));
            $this->assertGreaterThan(0, filesize(public_path($f)), "$f must not be empty");
        }
        $ico = file_get_contents(public_path('favicon.ico'));
        $this->assertSame("\x00\x00\x01\x00", substr($ico, 0, 4), 'favicon.ico must be a real ICO file');

        $admin = User::create(['name' => 'A', 'email' => 'a_'.uniqid().'@example.com', 'password' => bcrypt('x12345678')]);
        $pages = [
            // Guest pages first: once logged in as admin, /login correctly redirects away.
            'admin login' => fn () => $this->get('/login'),
            'customer login' => fn () => $this->get(route('customer.login')),
            'customer forgot password' => fn () => $this->get(route('customer.password.request')),
            'admin dashboard' => fn () => $this->actingAs($admin)->get('/admin'),
        ];
        foreach ($pages as $name => $req) {
            $html = $req()->assertOk()->getContent();
            $this->assertStringContainsString('favicon-32x32.png', $html, "$name is missing the favicon");
            $this->assertStringContainsString('apple-touch-icon.png', $html, "$name is missing the touch icon");
            $this->assertStringNotContainsString('f_assets/images/favicon.png', $html, "$name still links the missing favicon");
        }
    }
}
