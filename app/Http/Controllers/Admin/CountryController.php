<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CountryRequest;
use App\Models\CountriesModel;
use App\Services\ImageUploader;
use Illuminate\Support\Facades\Session;

/** Country landing pages, served publicly at /country/{slug}. */
class CountryController extends Controller
{
    private const IMAGE_DIR = 'uploads/countries';

    public function __construct(private ImageUploader $uploader) {}

    public function index()
    {
        return view('admin.country.index')->with('country', CountriesModel::all());
    }

    public function create()
    {
        return view('admin.country.create');
    }

    public function store(CountryRequest $request)
    {
        $country = CountriesModel::create($request->countryData());
        $this->saveImages($request, $country->id, false);

        Session::flash('msg', 'country added Successfully!');
        Session::flash('class', 'alert-success');

        return redirect()->route('admin-country.index');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        return view('admin.country.edit')->with('country', CountriesModel::findOrFail($id));
    }

    public function update(CountryRequest $request, string $id)
    {
        CountriesModel::findOrFail($id);
        CountriesModel::where('id', $id)->update($request->countryData());
        $this->saveImages($request, $id, true);

        Session::flash('msg', 'country Updated Successfully!');
        Session::flash('class', 'alert-success');

        return redirect()->route('admin-country.index');
    }

    public function destroy(string $id)
    {
        CountriesModel::findOrFail($id)->delete();
        Session::flash('msg', 'Country Deleted Successfully!');
        Session::flash('class', 'alert-success');

        return redirect()->route('admin-country.index');
    }

    /** Store each uploaded image; on edit, an upload replaces the image already in that slot. */
    private function saveImages(CountryRequest $request, int|string $countryId, bool $replace): void
    {
        foreach (CountryRequest::IMAGE_FIELDS as $slot) {
            if (! $request->hasFile($slot)) {
                continue;
            }
            $replace
                ? $this->uploader->replace($request->file($slot), self::IMAGE_DIR, $countryId, $slot)
                : $this->uploader->attach($request->file($slot), self::IMAGE_DIR, $countryId, $slot);
        }
    }
}
