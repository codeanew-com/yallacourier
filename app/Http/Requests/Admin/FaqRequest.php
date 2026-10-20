<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class FaqRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'question' => 'required|string|max:1000',
            'answer' => 'required|string',
            'show_on_home' => 'required|in:0,1',
            'status' => 'required|in:0,1',
        ];
    }

    /** Only the editable columns are ever written. */
    public function faqData(): array
    {
        return $this->only(['question', 'answer', 'show_on_home', 'status']);
    }
}
