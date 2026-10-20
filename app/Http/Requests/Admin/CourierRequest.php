<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/** A courier's pickup window and its domestic/international rates. */
class CourierRequest extends FormRequest
{
    /** Numeric rate/setting columns, all stored as integers. */
    public const NUMERIC_FIELDS = [
        'over_head', 'service_fee', 'comission', 'comission_document', 'normal_days', 'non_normal_days',
        'over_head_intl', 'service_fee_intl', 'comission_intl', 'comission_document_intl', 'normal_days_intl', 'non_normal_days_intl',
        'saudi_tax',
    ];

    /** The list's Activate/Deactivate button posts only the new status to the update route. */
    public function isStatusToggle(): bool
    {
        return $this->routeIs('admin-couriers.update') && $this->has('toggle_status');
    }

    public function rules(): array
    {
        if ($this->isStatusToggle()) {
            return [];
        }

        $rules = [
            'name' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'status' => 'required|in:0,1',
        ];
        foreach (self::NUMERIC_FIELDS as $f) {
            $rules[$f] = 'required|integer|min:0|max:100000';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'end_time.after' => 'The pickup end time must be later than the start time.',
            '*.integer' => 'The :attribute must be a whole number.',
        ];
    }

    public function attributes(): array
    {
        return [
            'over_head' => 'overhead', 'over_head_intl' => 'international overhead',
            'comission' => 'parcel commission', 'comission_document' => 'document commission',
            'comission_intl' => 'international parcel commission', 'comission_document_intl' => 'international document commission',
            'service_fee_intl' => 'international service fee', 'normal_days' => 'delivery days', 'non_normal_days' => 'extra delivery days',
            'normal_days_intl' => 'international delivery days', 'non_normal_days_intl' => 'international extra delivery days',
        ];
    }
}
