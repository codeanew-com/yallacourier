<?php

namespace App\Http\Requests\Customer;

use App\Http\Requests\Concerns\FlashesFirstError;
use Illuminate\Foundation\Http\FormRequest;

/** The customer's own profile page. Email and password are not editable here. */
class UpdateProfileRequest extends FormRequest
{
    use FlashesFirstError;

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:30',
        ];
    }
}
