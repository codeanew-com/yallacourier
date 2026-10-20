<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/** Bulk action on selected business leads. */
class BulkBusinessLeadRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'action' => 'required|in:read,unread,archive,restore,delete',
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer',
        ];
    }

    public function messages(): array
    {
        return ['ids.required' => 'Select at least one lead first.'];
    }
}
