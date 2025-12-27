<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InquiryRequest extends FormRequest
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
            'mode' => 'required|integer|in:1,2',
            'priority' => 'required|integer|in:1,2',
            'shipment' => 'required|integer',
            'origin' => 'required|integer',
            'type' => 'required|integer',
            'commodity' => 'required|string|max:255',
            'pickup_reference' => 'nullable|string|max:255',
            'user_reference_number' => 'nullable|string|max:255',
            'date' => 'required|string|max:255',
            'incoterms' => 'required|string|max:255',
            'dest' => 'nullable|string|max:255',
            'dest_postal_code' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'user_agent' => 'nullable|string',
            'ip' => 'nullable|ip',

            // Add array validation for measurements
            'measurements' => 'required|array', 
            'measurements.*.weight' => 'required|numeric',
            'measurements.*.width' => 'required|numeric',
            'measurements.*.height' => 'required|numeric',
            'measurements.*.length' => 'required|numeric',
            'measurements.*.quantity' => 'required|integer|min:1',
            'measurements.*.dimension_unit' => 'required',
            'measurements.*.weight_unit' => 'required',


            // Broker details
            'company_name' => 'nullable|string',
            'contact_name' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email', 

            // Conditions for pickup
            'inside_pickup' => 'boolean',
            'residential_pickup' => 'boolean',
            'liftgate_required' => 'boolean',
            'do_not_stack' => 'boolean',
        ];
    }
}
