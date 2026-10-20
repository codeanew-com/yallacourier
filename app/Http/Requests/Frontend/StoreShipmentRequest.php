<?php

namespace App\Http\Requests\Frontend;

use App\Http\Requests\Concerns\FlashesFirstError;
use App\Rules\NoControlCharacters;
use Illuminate\Foundation\Http\FormRequest;

/** Public "book a shipment" form (guests and logged-in customers). */
class StoreShipmentRequest extends FormRequest
{
    use FlashesFirstError;

    public function rules(): array
    {
        return [
            'sender_name' => 'required|string|max:255',
            'sender_phone' => 'required|string|max:30',
            'sender_email' => ['required', 'email', 'max:255', new NoControlCharacters],
            'reciever_name' => 'required|string|max:255',
            'reciever_phone' => 'required|string|max:30',
            'reciever_email' => ['required', 'email', 'max:255', new NoControlCharacters],
            'shipment_qty' => 'required|array|min:1',
            'shipment_length' => 'required|array|min:1',
            'shipment_width' => 'required|array|min:1',
            'shipment_height' => 'required|array|min:1',
            'shipment_weight' => 'required|array|min:1',
        ];
    }

    protected function keepsInputOnFailure(): bool
    {
        return true;
    }
}
