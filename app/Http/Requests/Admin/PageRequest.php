<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/** Create / edit a CMS page (title, URL slug, SEO settings, visibility). */
class PageRequest extends FormRequest
{
    /**
     * Fill what the admin left blank: slug from the title, SEO title from the
     * title, canonical URL from the slug. Same rules as the form's live helpers.
     */
    protected function prepareForValidation(): void
    {
        $slug = Str::slug((string) ($this->filled('slug') ? $this->slug : $this->title));
        $this->merge([
            'slug' => $slug,
            'page_title' => $this->filled('page_title') ? $this->page_title : $this->title,
            // Default to the page's live URL (not url(), which is 127.0.0.1 when edited on a dev machine).
            'page_cron_url' => $this->filled('page_cron_url') ? $this->page_cron_url : rtrim((string) config('app.public_url'), '/').'/'.$slug,
            'meta_description' => trim(strip_tags((string) $this->meta_description)),
            'visibility' => $this->input('visibility', 'index,follow'),
            'has_meta' => $this->input('has_meta', 1),
            'show_in_footer' => $this->input('show_in_footer', 0),
        ]);
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            // Unique among live pages — the old check let an edit take another page's slug.
            'slug' => ['required', 'max:255', Rule::unique('pages', 'slug')->ignore($this->route('page'))->whereNull('deleted_at')],
            'page_title' => 'required|string|max:255',
            'meta_description' => 'required|string|max:255',
            // Canonicals pointing at localhost/.test copies were found live; only the public site is allowed.
            'page_cron_url' => ['required', 'url', 'max:255', function ($attr, $value, $fail) {
                $host = fn ($u) => preg_replace('/^www\./', '', strtolower((string) parse_url($u, PHP_URL_HOST)));
                if ($host($value) !== $host((string) config('app.public_url'))) {
                    $fail('The canonical URL must be on '.$host((string) config('app.public_url')).'. Leave it empty to use this page’s own address.');
                }
            }],
            'visibility' => ['required', Rule::in(['index,follow', 'noindex,nofollow'])],
            'status' => 'required|in:0,1',
            'has_meta' => 'required|in:0,1',
            'show_in_footer' => 'required|in:0,1',
        ];
    }

    public function messages(): array
    {
        return [
            'slug.unique' => 'Another page already uses the URL slug ":input". Choose a different slug.',
            'slug.required' => 'Enter a title or slug so the page gets a URL.',
        ];
    }

    public function attributes(): array
    {
        return ['page_title' => 'SEO title', 'page_cron_url' => 'canonical URL'];
    }
}
