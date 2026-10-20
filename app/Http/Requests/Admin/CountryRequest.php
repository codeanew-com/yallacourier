<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/** A country landing page (/country/{slug}): seven content sections plus their images. */
class CountryRequest extends FormRequest
{
    /** Image inputs on the form, stored in the files table with ref_point = input name. */
    public const IMAGE_FIELDS = [
        'landing_banner_background',
        'section_one_image',
        'section_2_image_1', 'section_2_image_2', 'section_2_image_3', 'section_2_image_4',
        'section_3_image_1', 'section_3_image_2', 'section_3_image_3', 'section_3_image_4',
        'section_4_image_1', 'section_4_image_2', 'section_4_image_3',
        'section_7_image_1', 'section_7_image_2', 'section_7_image_3', 'section_7_image_4', 'section_7_image_5', 'section_7_image_6', 'section_7_image_7',
    ];

    private const REQUIRED_TEXT = [
        'title', 'banner_title',
        'sec_one_title', 'sec_one_content',
        'sec_two_title', 'sec_two_subheading_1', 'sec_two_subheading_2', 'sec_two_subheading_3', 'sec_two_subheading_4',
        'sec_three_title', 'sec_three_subheading_1', 'sec_three_subheading_2', 'sec_three_subheading_3', 'sec_three_subheading_4',
        'sec_three_content_1', 'sec_three_content_2', 'sec_three_content_3', 'sec_three_content_4',
        'sec_four_title', 'sec_four_subheading_1', 'sec_four_subheading_2', 'sec_four_subheading_3',
        'sec_four_content_1', 'sec_four_content_2', 'sec_four_content_3',
        'sec_five_title', 'sec_six_title', 'sec_seven_title', 'sec_seven_content',
    ];

    private function isUpdate(): bool
    {
        return $this->routeIs('admin-country.update');
    }

    protected function prepareForValidation(): void
    {
        if ($this->isUpdate()) {
            // Existing slugs (some capitalised, e.g. 'Bahrain') are kept as-is so live URLs don't change.
            if (! $this->filled('slug')) {
                $this->merge(['slug' => Str::slug((string) $this->title)]);
            }

            return;
        }

        $this->merge(['slug' => Str::slug((string) ($this->filled('slug') ? $this->slug : $this->title))]);
    }

    public function rules(): array
    {
        $slug = ['required', Rule::unique('countries', 'slug')->ignore($this->isUpdate() ? $this->route('country') : null)->whereNull('deleted_at')];

        // Title, then slug, then the sections — the order errors are listed in.
        return ['title' => 'required', 'slug' => $slug] + array_fill_keys(self::REQUIRED_TEXT, 'required');
    }

    /** Every posted text field (the images are stored separately). */
    public function countryData(): array
    {
        return $this->except(array_merge(['_token', '_method'], self::IMAGE_FIELDS));
    }
}
