<?php

namespace App\Http\Requests\Customer;

use App\Rules\NoControlCharacters;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

/** Reset (forgot-password link) or first-time setup (?setup=1) of a customer password. */
class ResetPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'token' => 'required|string',
            'email' => ['required', 'email', new NoControlCharacters],
            // Password::defaults() is the customer password policy, set in AppServiceProvider.
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }
}
