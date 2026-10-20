<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Content\PageMetaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

/** Section-by-section content editor for the built-in pages. */
class PageMetaController extends Controller
{
    /** Editor template per built-in page id. */
    private const EDITORS = [
        1 => 'admin.pagemeta.home.index',
        2 => 'admin.pagemeta.aboutus.index',
        3 => 'admin.pagemeta.contactus.index',
        4 => 'admin.pagemeta.uaeparceldelivery.index',
        5 => 'admin.pagemeta.largeheavyparcel.index',
        6 => 'admin.pagemeta.ourcourier.index',
        7 => 'admin.pagemeta.labelingandpackaging.index',
        8 => 'admin.pagemeta.shippingmadesimple.index',
        9 => 'admin.pagemeta.volumetricweightcalculator.index',
        12 => 'admin.pagemeta.parcelcollectiondelivery.index',
        13 => 'admin.pagemeta.qatar.index',
        17 => 'admin.pagemeta.business.index',
        18 => 'admin.pagemeta.kuwait.index',
        19 => 'admin.pagemeta.lebanon.index',
        20 => 'admin.pagemeta.jordan.index',
        21 => 'admin.pagemeta.oman.index',
        22 => 'admin.pagemeta.bahrain.index',
        23 => 'admin.pagemeta.saudi.index',
    ];

    /** Pages without their own editor use the UAE parcel delivery one (see PageMetaService::DEFAULT_IMAGE_SLOTS). */
    private const DEFAULT_EDITOR = 'admin.pagemeta.uaeparceldelivery.index';

    public function edit(string $id)
    {
        $view = is_numeric($id) ? (self::EDITORS[(int) $id] ?? self::DEFAULT_EDITOR) : self::DEFAULT_EDITOR;

        return view($view)->with('id', $id);
    }

    public function update(Request $request, PageMetaService $pageMeta)
    {
        $pageId = $request->page_id;

        if ($request->has('page_meta')) {
            $pageMeta->saveText($pageId, (array) $request->page_meta);
        }

        $uploads = [];
        foreach (PageMetaService::imageSlotsFor($pageId) as $slot) {
            if ($request->hasFile($slot)) {
                $uploads[$slot] = $request->file($slot);
            }
        }
        $pageMeta->saveImages($pageId, $uploads);

        Session::flash('msg', 'Setting Updated Successfully');
        Session::flash('class', 'alert-success');

        return redirect()->back();
    }
}
