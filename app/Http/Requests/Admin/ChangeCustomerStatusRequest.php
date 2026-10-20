<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Admin\Concerns\TargetsCustomer;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

/** Suspend / ban / disable / reactivate a customer account. */
class ChangeCustomerStatusRequest extends FormRequest
{
    use TargetsCustomer;

    /** Errors go to their own bag so the status modal, not the edit form, shows them. */
    protected $errorBag = 'status';

    public function authorize(): bool
    {
        return $this->user()->can('manageAccess', $this->customer());
    }

    public function rules(): array
    {
        return [
            'action' => 'required|in:suspend,ban,disable,reactivate',
            'reason' => 'required_unless:action,reactivate|nullable|string|max:1000',
            'suspended_until' => 'nullable|date|after:now',
        ];
    }

    public function messages(): array
    {
        return [
            'reason.required_unless' => 'Please give a reason. It is shown to other admins on the customer\'s profile.',
            'suspended_until.after' => 'The suspension end must be in the future.',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        session()->flash('msg', $validator->errors()->first());
        session()->flash('class', 'alert-danger');

        parent::failedValidation($validator);
    }
}
