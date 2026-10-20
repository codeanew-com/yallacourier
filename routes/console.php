<?php

use App\Services\Content\SitemapGenerator;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// php artisan sitemap:generate — same rules as the admin "Generate sitemap" button (run after deploys).
Artisan::command('sitemap:generate', function () {
    $r = app(SitemapGenerator::class)->generate();
    $this->info("Wrote {$r['count']} URLs to {$r['path']}");
    foreach ($r['urls'] as $u) {
        $this->line('  '.$u);
    }
})->purpose('Regenerate public/sitemap.xml from published, indexable CMS pages');

// Queue worker for shared hosting (no long-running processes): the server cron runs
// `php artisan schedule:run` every minute, which sends whatever is queued (e.g. new
// business lead emails) and exits. withoutOverlapping() stops two workers piling up.
Schedule::command('queue:work --stop-when-empty --max-time=50 --tries=3')
    ->everyMinute()
    ->withoutOverlapping(5);
