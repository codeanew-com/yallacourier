<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Admin\Concerns\TargetsCustomer;
use App\Rules\NoControlCharacters;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/** Admin edits a customer's contact details. */
class UpdateCustomerRequest extends FormRequest
{
    use TargetsCustomer;

    public function authorize(): bool
    {
        return $this->user()->can('update', $this->customer());
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['email' => strtolower(trim((string) $this->email))]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email:rfc', 'max:255', new NoControlCharacters, Rule::unique('customers', 'email')->ignore($this->customer()->id)],
            'phone' => ['nullable', 'string', 'max:30', 'regex:/^[0-9+()\-\s]{6,30}$/'],
            'company_name' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'Another customer account already uses this email address.',
            'phone.regex' => 'Enter a valid phone number (digits, spaces, + - and brackets only).',
        ];
    }
}
