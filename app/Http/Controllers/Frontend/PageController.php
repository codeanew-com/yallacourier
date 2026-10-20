<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CountriesModel;
use App\Models\HsCode;
use App\Models\PageModel;

/** Public CMS pages, country pages and small public endpoints. */
class PageController extends Controller
{
    /**
     * Built-in pages with their own template, by page id (= PageModel::SYSTEM_PAGE_IDS).
     * Any other published page uses the generic custom page template.
     */
    private const TEMPLATES = [
        1 => 'frontend.home.index',
        2 => 'frontend.aboutus.index',
        3 => 'frontend.contactus.index',
        4 => 'frontend.uaeparceldelivery.index',
        5 => 'frontend.largeheavyparcel.index',
        6 => 'frontend.ourcourier.index',
        7 => 'frontend.labelingandpackaging.index',
        8 => 'frontend.shippingmadesimple.index',
        9 => 'frontend.volumetricweightcalculator.index',
        12 => 'frontend.parcelcollectiondelivery.index',
        13 => 'frontend.qatar.index',
        14 => 'frontend.page.faq',
        15 => 'frontend.page.termandcondition',
        16 => 'frontend.page.privacypolicy',
        17 => 'frontend.business.index',
        18 => 'frontend.kuwait.index',
        19 => 'frontend.lebanon.index',
        20 => 'frontend.jordan.index',
        21 => 'frontend.oman.index',
        22 => 'frontend.bahrain.index',
        23 => 'frontend.saudi.index',
        24 => 'frontend.aramexyallacourier.index',
        25 => 'frontend.emiratespost.index',
        26 => 'frontend.luggage.index',
    ];

    private const CUSTOM_TEMPLATE = 'frontend.custompage.index';

    /** "/" is the home page; "/{slug}" any CMS page by slug. */
    public function show(?string $slug = null)
    {
        if (! $slug) {
            return view(self::TEMPLATES[PageModel::HOME_ID])->with('page', PageModel::find(PageModel::HOME_ID));
        }

        $page = PageModel::where('slug', $slug)->first() ?? abort(404);

        return view(self::TEMPLATES[(int) $page->id] ?? self::CUSTOM_TEMPLATE)->with('page', $page);
    }

    public function country(string $slug)
    {
        if (CountriesModel::where('slug', $slug)->where('status', 1)->count() === 0) {
            abort(404);
        }

        return view('frontend.singlecountry.index')->with('country', CountriesModel::where('slug', $slug)->first());
    }

    public function thankYou()
    {
        return view('frontend.thankyou.index');
    }

    public function leadThankYou()
    {
        return view('frontend.lead-thankyou.index');
    }

    /** HS code autocomplete (HTML list items) for the booking form. */
    public function hsCodes()
    {
        $html = '';
        foreach (HsCode::where('status', 'like', '%'.request('id').'%')->get() as $code) {
            if ($code->status != '') {
                $html .= '<li data-id="'.$code->code.'" class="use_me">'.$code->status.'</li>';
            }
        }

        return response($html);
    }
}
