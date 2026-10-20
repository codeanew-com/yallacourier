<?php

namespace App\Http\Requests\Admin;

use App\Models\CourierModel;
use App\Models\OrderModel;
use App\Rules\NoControlCharacters;
use App\Services\Orders\OrderUpdater;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/** The admin order screen: status, payment, courier, pricing, addresses and packages. */
class UpdateOrderRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'status' => ['required', Rule::in(OrderModel::STATUSES)],
            'payment_status' => 'required|in:0,1',
            'courier' => ['required', 'integer', Rule::in(array_merge([0], CourierModel::pluck('id')->all()))],
            'subtotal' => 'required|numeric|min:0',
            'vat' => 'required|numeric|min:0',
            'courier_quote' => 'nullable|numeric|min:0',
            'courier_vat' => 'required|numeric|min:0',
            'comission' => 'nullable|numeric|min:0',
            'commission_mode' => 'nullable|in:auto,manual',
            'commission_basis' => 'nullable|in:parcel,document',
            'over_head' => 'required|numeric|min:0',
            'service_fee' => 'required|numeric|min:0',
            'sender_email' => ['nullable', 'email', 'max:255', new NoControlCharacters],
            'reciever_email' => ['nullable', 'email', 'max:255', new NoControlCharacters],
            'declared_value' => 'nullable|numeric|min:0',
            'dimension_id' => 'nullable|array',
            'dimension_id.*' => 'integer',
            'dimension_qty.*' => 'required|integer|min:1',
            'dimension_length.*' => 'required|integer|min:0',
            'dimension_width.*' => 'required|integer|min:0',
            'dimension_height.*' => 'required|integer|min:0',
            'dimension_weight.*' => 'required|integer|min:0',
        ];
        foreach (OrderUpdater::META_KEYS as $key) {
            $rules[$key] = $rules[$key] ?? 'nullable|string|max:1000';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'dimension_qty.*.min' => 'Each package needs a quantity of at least 1.',
            'dimension_qty.*.*' => 'Package quantities must be whole numbers.',
            'dimension_length.*.*' => 'Package dimensions must be whole centimetres (0 or more).',
            'dimension_width.*.*' => 'Package dimensions must be whole centimetres (0 or more).',
            'dimension_height.*.*' => 'Package dimensions must be whole centimetres (0 or more).',
            'dimension_weight.*.*' => 'Package weights must be whole kilograms (0 or more).',
            'courier.in' => 'Please choose a courier from the list.',
        ];
    }

    public function attributes(): array
    {
        return [
            'comission' => 'commission',
            'over_head' => 'overhead',
            'reciever_email' => 'receiver email',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        session()->flash('msg', 'Nothing was saved — please fix the highlighted fields.');
        session()->flash('class', 'alert-danger');

        parent::failedValidation($validator);
    }
}
