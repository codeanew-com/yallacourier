<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Content\SitemapGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

/** Edit public/robots.txt and public/sitemap.xml. */
class SeoController extends Controller
{
    public function editRobots()
    {
        return view('admin.setting.txt.edit')->with('content', file_get_contents(public_path('robots.txt')));
    }

    public function updateRobots(Request $request)
    {
        if (trim((string) $request->content) === '') {
            // An empty robots.txt was never written; say so instead of reporting success.
            return $this->back('robots.txt was not changed: the content cannot be empty.', 'alert-warning');
        }
        file_put_contents(public_path('robots.txt'), $request->content);

        return $this->back('robots.txt saved.');
    }

    public function editSitemap()
    {
        return view('admin.setting.sitemap.edit')->with('content', file_get_contents(public_path('sitemap.xml')));
    }

    public function generateSitemap(SitemapGenerator $generator)
    {
        $result = $generator->generate();

        return $this->back('Sitemap generated with '.$result['count'].' indexable pages, using canonical live URLs ('.config('app.public_url').').');
    }

    public function updateSitemap(Request $request)
    {
        libxml_use_internal_errors(true);
        $valid = trim((string) $request->content) !== '' && simplexml_load_string((string) $request->content) !== false;
        libxml_clear_errors();
        if (! $valid) {
            // Saving broken XML would silently break the sitemap for search engines.
            return $this->back('Sitemap not saved: the content is not valid XML. Fix it, or use "Generate sitemap" to rebuild it.', 'alert-danger')->withInput();
        }
        file_put_contents(public_path('sitemap.xml'), $request->content);

        return $this->back('Sitemap saved.');
    }

    private function back(string $msg, string $class = 'alert-success')
    {
        Session::flash('msg', $msg);
        Session::flash('class', $class);

        return redirect()->back();
    }
}
