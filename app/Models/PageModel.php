<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PageModel extends Model
{
    use SoftDeletes;

    protected $table = 'pages';

    /** Page 1 is the home page and is served at "/" (also reachable as /home). */
    public const HOME_ID = 1;

    /**
     * Pages the public site renders with a dedicated template
     * (Frontend\PageController::TEMPLATES). Deleting one breaks that part of
     * the site, so the admin can edit them but not delete them.
     */
    public const SYSTEM_PAGE_IDS = [1, 2, 3, 4, 5, 6, 7, 8, 9, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26];

    /** The page's own public URL on the live site. */
    public function publicUrl(): string
    {
        $base = rtrim((string) config('app.public_url'), '/');

        return (int) $this->id === self::HOME_ID ? $base.'/' : $base.'/'.ltrim((string) $this->slug, '/');
    }

    /**
     * The URL to put in <link rel="canonical"> and the sitemap.
     *
     * Uses the admin's stored canonical (page_cron_url) only when it is a valid
     * URL on the live site. Live data contained canonicals such as
     * "http://localhost/yalla-courier/public" and "https://yalla-courier.test/",
     * which tell search engines the page lives somewhere else, so those (and
     * empty or relative values) fall back to the page's own public URL. A
     * canonical that differs from the page's own URL only by letter case
     * (e.g. /Shipping-Made-Simple) is normalised to the real URL. A deliberate
     * canonical to another page of the site is kept.
     */
    public function canonicalUrl(): string
    {
        $own = $this->publicUrl();
        $stored = trim((string) $this->page_cron_url);
        if ($stored === '' || ! filter_var($stored, FILTER_VALIDATE_URL)) {
            return $own;
        }

        $host = fn ($u) => preg_replace('/^www\./', '', strtolower((string) parse_url($u, PHP_URL_HOST)));
        if ($host($stored) !== $host($own)) {
            return $own;
        }

        $path = fn ($u) => '/'.trim((string) parse_url($u, PHP_URL_PATH), '/');
        if (strcasecmp($path($stored), $path($own)) === 0
            || ((int) $this->id === self::HOME_ID && strcasecmp($path($stored), '/'.trim((string) $this->slug, '/')) === 0)) {
            return $own; // same page (different letter case, or /home for the home page)
        }

        return $stored;
    }

    /** True when the stored canonical is being overridden — shown as a warning in the admin. */
    public function hasInvalidStoredCanonical(): bool
    {
        $stored = trim((string) $this->page_cron_url);

        return $stored !== '' && $stored !== $this->canonicalUrl();
    }
}
