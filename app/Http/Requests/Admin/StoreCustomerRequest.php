<?php

namespace App\Http\Requests\Admin;

use App\Models\CustomerModel;
use App\Rules\NoControlCharacters;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/** Admin creates a customer account (the only way accounts are created). */
class StoreCustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', CustomerModel::class);
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['email' => strtolower(trim((string) $this->email))]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email:rfc', 'max:255', new NoControlCharacters, Rule::unique('customers', 'email')],
            'phone' => ['nullable', 'string', 'max:30', 'regex:/^[0-9+()\-\s]{6,30}$/'],
            'company_name' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'account_status' => ['required', Rule::in([CustomerModel::ACTIVE, CustomerModel::DISABLED])],
            'onboarding' => 'required|in:invite,temporary',
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'A customer account with this email already exists.',
            'phone.regex' => 'Enter a valid phone number (digits, spaces, + - and brackets only).',
        ];
    }
}
