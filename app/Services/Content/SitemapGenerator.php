<?php

namespace App\Services\Content;

use App\Models\PageModel;

/**
 * Builds public/sitemap.xml from the CMS pages (admin "Generate sitemap" and
 * `php artisan sitemap:generate`).
 *
 * Rules, so the sitemap only lists URLs search engines should index:
 *  - published pages only, never noindex ones
 *  - each page's canonical public URL (PageModel::canonicalUrl), so the home
 *    page is "/" not "/home", and a page whose canonical points at another
 *    page is left out (only the canonical target is listed)
 *  - every URL on the live domain (config app.public_url), even when generated
 *    on a dev machine; URLs listed once
 */
class SitemapGenerator
{
    /** @return array{count:int, path:string, urls:array<int,string>} */
    public function generate(): array
    {
        $entries = [];
        foreach (PageModel::where('status', 1)->orderBy('id')->get() as $page) {
            if (str_contains(strtolower((string) $page->visibility), 'noindex')) {
                continue;
            }
            $canonical = $page->canonicalUrl();
            if ($canonical !== $page->publicUrl() || isset($entries[$canonical])) {
                continue;
            }
            $entries[$canonical] = ($page->updated_at ?? $page->created_at)?->format('Y-m-d');
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n".'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";
        foreach ($entries as $loc => $lastmod) {
            $xml .= '  <url><loc>'.htmlspecialchars($loc, ENT_XML1).'</loc>'
                .($lastmod ? '<lastmod>'.$lastmod.'</lastmod>' : '')
                .'<changefreq>monthly</changefreq><priority>'.(str_ends_with(parse_url($loc, PHP_URL_PATH) ?: '/', '/') && substr_count(parse_url($loc, PHP_URL_PATH) ?: '/', '/') === 1 ? '1.0' : '0.8').'</priority></url>'."\n";
        }
        $xml .= '</urlset>'."\n";

        $path = public_path('sitemap.xml');
        file_put_contents($path, $xml);
        $this->ensureRobotsReference();

        return ['count' => count($entries), 'path' => $path, 'urls' => array_keys($entries)];
    }

    public function sitemapUrl(): string
    {
        return rtrim((string) config('app.public_url'), '/').'/sitemap.xml';
    }

    /** Add "Sitemap: …" to robots.txt if it's missing (the rest of the file is left as the admin wrote it). */
    public function ensureRobotsReference(): bool
    {
        $robots = public_path('robots.txt');
        $content = is_file($robots) ? (string) file_get_contents($robots) : "User-agent: *\nDisallow:\n";
        if (preg_match('/^\s*Sitemap:/mi', $content)) {
            return false;
        }
        file_put_contents($robots, rtrim($content)."\n\nSitemap: ".$this->sitemapUrl()."\n");

        return true;
    }
}
