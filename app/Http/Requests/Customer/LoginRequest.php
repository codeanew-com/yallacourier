<?php

namespace App\Http\Requests\Customer;

use App\Http\Requests\Concerns\FlashesFirstError;
use App\Rules\NoControlCharacters;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    use FlashesFirstError;

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', new NoControlCharacters],
            'password' => 'required',
        ];
    }
}
