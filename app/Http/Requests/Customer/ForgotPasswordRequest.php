<?php

namespace App\Http\Requests\Customer;

use App\Rules\NoControlCharacters;
use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return ['email' => ['required', 'email', 'max:255', new NoControlCharacters]];
    }
}
