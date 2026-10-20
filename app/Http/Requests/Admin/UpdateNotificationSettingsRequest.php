<?php

namespace App\Http\Requests\Admin;

use App\Rules\NoControlCharacters;
use App\Services\Leads\BusinessLeadNotifier;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

/** Admin → Configuration → Notifications. */
class UpdateNotificationSettingsRequest extends FormRequest
{
    /** Addresses are entered as one list; validate them one by one. */
    protected function prepareForValidation(): void
    {
        $this->merge(['lead_emails' => BusinessLeadNotifier::parse($this->input('business_lead_emails'))]);
    }

    public function rules(): array
    {
        return [
            'business_lead_emails' => ['nullable', 'string', 'max:1000'],
            'lead_emails' => ['array', 'max:10'],
            'lead_emails.*' => ['email:rfc', 'max:255', new NoControlCharacters],
        ];
    }

    public function messages(): array
    {
        return [
            'lead_emails.*.email' => '":input" is not a valid email address.',
            'lead_emails.max' => 'Enter at most 10 addresses.',
        ];
    }

    /** Errors on individual addresses are shown under the one input. */
    protected function failedValidation(Validator $validator): void
    {
        throw ValidationException::withMessages([
            'business_lead_emails' => $validator->errors()->all(),
        ])->redirectTo($this->getRedirectUrl());
    }
}
