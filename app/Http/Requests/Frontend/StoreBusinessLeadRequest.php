<?php

namespace App\Http\Requests\Frontend;

use App\Rules\NoControlCharacters;
use Illuminate\Foundation\Http\FormRequest;

/** Public business sign-up / enquiry form. */
class StoreBusinessLeadRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', new NoControlCharacters],
            'phone' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'number_of_parcel' => 'required|string|max:255',
            // 'reason_for_switching_provider' => 'required|string|max:255',
            'current_delivery_partner' => 'required|string|max:255',
        ];
    }
}
