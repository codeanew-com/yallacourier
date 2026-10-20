<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/** Customer testimonial. The author photo is required when adding, optional when editing. */
class ReviewRequest extends FormRequest
{
    public function rules(): array
    {
        $imageRequired = $this->routeIs('admin-review.store');

        return [
            'review' => 'required|string',
            'author_name' => 'required|string|max:255',
            'author_designation' => 'required|string|max:255',
            'author_image' => [$imageRequired ? 'required' : 'nullable', 'file', 'max:4096', 'mimes:jpg,jpeg,png,gif,webp,svg'],
            'show_on_home' => 'required|in:0,1',
            'status' => 'required|in:0,1',
        ];
    }

    public function messages(): array
    {
        return [
            'author_image.mimes' => 'The author photo must be an image (JPG, PNG, GIF, WebP or SVG).',
            'author_image.max' => 'The author photo must be smaller than 4 MB.',
        ];
    }

    public function attributes(): array
    {
        return ['author_image' => 'author photo'];
    }

    /** Only the editable columns are ever written. */
    public function reviewData(): array
    {
        return $this->only(['review', 'author_name', 'author_designation', 'show_on_home', 'status']);
    }
}
