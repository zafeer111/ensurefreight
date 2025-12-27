<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuotationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'inquiry_id' => 'required',
            'reference_no_id' => 'required',
            'from' => 'required',
            'to' => 'required',
            'weight' => 'required|numeric',
            'pickup_carrier_name' => 'required',
            'profit' => 'nullable|numeric',
            'pickup_charge' => 'nullable|numeric',
            'bonded_charge' => 'nullable|numeric',
            'cargo_type' => 'required',
            'quotation_status' => 'required',

            'carriers.*.carrier_id' => 'required|exists:carriers,id',
            'carriers.*.tariff_rate' => 'required|numeric',
            'carriers.*.surcharge' => 'nullable|numeric',
            'carriers.*.airable_charge' => 'nullable|numeric',
            'carriers.*.custom_charge' => 'nullable|numeric',
            'carriers.*.rate_per_kg' => 'required|numeric',
            'carriers.*.zero_profit_rate' => 'nullable|numeric',
            'carriers.*.total_rate' => 'required|numeric',
            'carriers.*.quotation_line_items_status' => 'required|numeric',
        ];
    }
}