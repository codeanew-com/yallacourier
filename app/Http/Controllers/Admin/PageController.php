<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PageRequest;
use App\Models\PageModel;
use App\Services\ActivityLogger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

/** CMS pages: URL, SEO and visibility. Section content is edited in PageMetaController. */
class PageController extends Controller
{
    public function __construct(private ActivityLogger $activity) {}

    public function index()
    {
        return view('admin.pages.index')
            ->with('page', PageModel::orderBy('title')->get())
            ->with('systemIds', PageModel::SYSTEM_PAGE_IDS)
            ->with('duplicateSlugs', PageModel::select('slug')->groupBy('slug')->havingRaw('COUNT(*) > 1')->pluck('slug')->all());
    }

    public function create()
    {
        return view('admin.pages.form')->with('page', null);
    }

    public function store(PageRequest $request)
    {
        $page = new PageModel;
        $this->fill($page, $request);
        $page->save();
        $this->activity->record('A New Page with title '.$page->title.' was added');

        Session::flash('msg', 'Page "'.$page->title.'" created.');
        Session::flash('class', 'alert-success');

        return redirect()->route('admin-pages.index');
    }

    public function show(string $id)
    {
        return redirect()->route('admin-pages.edit', $id);
    }

    public function edit(string $id)
    {
        return view('admin.pages.form')->with('page', PageModel::findOrFail($id));
    }

    public function update(PageRequest $request, string $id)
    {
        $page = PageModel::findOrFail($id);
        $this->fill($page, $request);
        $page->save();
        $this->activity->record('A New Page with title '.$page->title.' was Updated');

        Session::flash('msg', 'Page "'.$page->title.'" saved.');
        Session::flash('class', 'alert-success');

        return redirect()->route('admin-pages.index');
    }

    public function destroy(string $id)
    {
        $page = PageModel::findOrFail($id);
        if (in_array((int) $page->id, PageModel::SYSTEM_PAGE_IDS, true)) {
            Session::flash('msg', '"'.$page->title.'" is a built-in page of the website and cannot be deleted. Set it to Draft to hide it instead.');
            Session::flash('class', 'alert-warning');

            return redirect()->back();
        }
        $page->delete();
        Session::flash('msg', 'Page "'.$page->title.'" deleted.');
        Session::flash('class', 'alert-success');

        return redirect()->back();
    }

    private function fill(PageModel $page, PageRequest $request): void
    {
        $page->title = $request->title;
        $page->slug = $request->slug;
        $page->page_title = $request->page_title;
        $page->meta_description = $request->meta_description;
        $page->page_cron_url = $request->page_cron_url;
        $page->visibility = $request->visibility;
        $page->status = $request->status;
        $page->has_meta = $request->has_meta;
        $page->show_in_footer = $request->show_in_footer;
        $page->added_by = Auth::id();
    }
}
