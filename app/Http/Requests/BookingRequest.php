<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'quotation_id' => 'required|integer',
            'reference_no_id' => 'required',
            'status' => 'required|string|in:0,1,2,3',
            'carrier_id' => 'required|integer',
            'tariff_rate' => 'required|string',
            'surcharge' => 'nullable|string',
            'airable_charge' => 'nullable|string',
            'custom_charge' => 'nullable|string',
            'rate_per_kg' => 'required|string',
            'total_rate' => 'required|string',
        ];
    }
}
