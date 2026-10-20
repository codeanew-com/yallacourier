<?php

namespace App\Http\Requests\Concerns;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * For the public/customer forms whose templates show a single flashed `msg`
 * line instead of per-field errors: on failure, go back with the first error
 * as `msg` (and no error bag).
 */
trait FlashesFirstError
{
    /** Whether the form should be refilled with what was typed. */
    protected function keepsInputOnFailure(): bool
    {
        return false;
    }

    protected function failedValidation(Validator $validator): void
    {
        $redirect = redirect()->back()->with('msg', $validator->errors()->first());

        throw new HttpResponseException($this->keepsInputOnFailure() ? $redirect->withInput() : $redirect);
    }
}
