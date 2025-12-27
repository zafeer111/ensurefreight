<?php

namespace App\Http\Controllers;

use App\Events\InquiryCreated;
use App\Http\Requests\InquiryRequest;
use App\Jobs\SendInquiryNotification;
use App\Models\Airport;
use App\Models\BrokerDetail;
use App\Models\City;
use App\Models\ConditionForPickup;
use App\Models\Country;
use App\Models\ExceptionInquiry;
use App\Models\Inquiry;
use App\Models\Measurement;
use App\Models\Quotation;
use App\Models\QuotationLineItem;
use App\Models\ReferenceNo;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class InquiryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.check');
    }

    public function index()
    {

        $user = Auth::user();
        $inquiries = Inquiry::where('customer_user_id', $user->id)
            ->latest('created_at')
            ->get();

        return view('inquiries.index', compact('inquiries',));
    }

    public function show($id)
    {
        $user = Auth::user();
        $inquiry = Inquiry::where('customer_user_id', $user->id)
            ->findOrFail($id);

        $mode = Config::get('constants.mode');
        $cargo_type = Config::get('constants.cargo_type');
        $priority = Config::get('constants.priority');
        $dimension_unit = Config::get('constants.dimension_unit');
        $weight_unit = Config::get('constants.weight_unit');

        return view('inquiries.show', compact('inquiry', 'mode', 'weight_unit', 'dimension_unit', 'priority', 'cargo_type'));
    }

    public function getStates($countryId)
    {
        $states = State::where('country_id', $countryId)->get();
        return response()->json($states);
    }

    public function getCities($stateId)
    {
        $cities = City::where('state_id', $stateId)->get();
        return response()->json($cities);
    }

    public function create()
    {
        $countries = Country::all();
        $airports = Airport::all();
        $userAddresses = auth()->user()->addresses;

        $mode = Config::get('constants.mode');
        $cargo_type = Config::get('constants.cargo_type');
        $priority = Config::get('constants.priority');
        $dimension_unit = Config::get('constants.dimension_unit');
        $weight_unit = Config::get('constants.weight_unit');

        return view('inquiries.create', compact('mode', 'userAddresses', 'countries', 'airports', 'weight_unit', 'dimension_unit', 'priority', 'cargo_type'));
    }

    public function store(InquiryRequest $request)
    {

        $userIp = $request->ip();
        $userAgent = $request->userAgent();
        // $referenceNoId = $this->generateUniqueReferenceNo();

        // Generate unique reference number
        $referenceData = $this->generateUniqueReferenceNo();
        $referenceNoId = $referenceData['id'];
        $referenceNo = $referenceData['reference_no'];

        // Create broker details
        $brokerDetail = BrokerDetail::create([
            'company_name' => $request->input('broker_company_name'),
            'contact_name' => $request->input('contact_name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
        ]);

        $inquiry = Inquiry::create([
            'mode' => $request->input('mode'),
            'commodity' => $request->input('commodity'),
            'pickup_date' => $request->input('pickup_date'),
            'priority' => $request->input('priority'),
            'cargo_type' => $request->input('type'),
            'pickup_date' => $request->input('date'),
            'shipment_address_id' => $request->input('shipment'),
            'pickup_address_id' => $request->input('origin'),
            'dest_iata' => $request->input('dest'),
            'destination_postal_code' => $request->input('dest_postal_code'),
            'broker_detail_id' => $brokerDetail->id,
            'incoterms' => $request->input('incoterms'),
            'pickup_reference' => $request->input('pickup_reference'),
            'user_reference_number' => $request->input('user_reference_number'),
            'reference_no_id' => $referenceNoId,
            'notes' => $request->input('notes'),
            'status' => $request->input('status'),
            'ip' => $userIp,
            'user_agent' => $userAgent,
            'customer_user_id' => auth()->user()->id,
        ]);

        $inquiry->save();

        // Create the ConditionForPickup
        ConditionForPickup::create([
            'inquiry_id' => $inquiry->id,
            'inside_pickup' => (bool) $request->input('inside_pickup', false),
            'residential_pickup' => (bool) $request->input('residential_pickup', false),
            'liftgate_required' => (bool) $request->input('liftgate_required', false),
            'do_not_stack' => (bool) $request->input('do_not_stack', false),
        ]);

        $measurementsData = $request->input('measurements');
        foreach ($measurementsData as $measurementData) {
            $measurement = new Measurement([
                'weight' => $measurementData['weight'],
                'width' => $measurementData['width'],
                'height' => $measurementData['height'],
                'length' => $measurementData['length'],
                'quantity' => $measurementData['quantity'],
                'dimension_unit' => $measurementData['dimension_unit'],
                'weight_unit' => $measurementData['weight_unit'],
            ]);


            $inquiry->measurements()->save($measurement);


            if ($request->has('from_exception')) {
                $exceptionInquiry = new ExceptionInquiry([
                    'inquiry_id' => $inquiry->id,
                    'exception_message' => $request->input('exception_message'),
                ]);

                $inquiry->exceptionInquiry()->save($exceptionInquiry);
            }

            SendInquiryNotification::dispatch($inquiry);
        }

        // Prepare data for JSON response
        $responseData = [
            'message' => 'Inquiry submitted successfully',
            'inquiry' => $inquiry->toArray(),
            'referenceNoId' => $referenceNoId,
            'referenceNo' => $referenceNo,
        ];
        return response()->json($responseData, 200);
    }

    public function edit($id)
    {
        $inquiry = Inquiry::findOrFail($id);
        $userAddresses = auth()->user()->addresses;

        $countries = Country::all();
        $mode = Config::get('constants.mode');
        $cargo_type = Config::get('constants.cargo_type');
        $priority = Config::get('constants.priority');
        $dimension_unit = Config::get('constants.dimension_unit');
        $weight_unit = Config::get('constants.weight_unit');

        return view('inquiries.edit', compact('inquiry', 'mode', 'countries', 'userAddresses', 'weight_unit', 'dimension_unit', 'priority', 'cargo_type'));
    }

    public function update(Request $request, $id)
    {
        $userIp = $request->ip();
        $userAgent = $request->userAgent();

        $inquiry = Inquiry::findOrFail($id);
        $shipmentAddressId = $request->input('previous_shipment_address');
        $pickupAddressId = $request->input('previous_pickup_address');
        $deliveryAddressId = $request->input('previous_delivery_address');

        $inquiry->brokerDetail->update([
            'company_name' => $request->input('broker_company_name'),
            'contact_name' => $request->input('contact_name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
        ]);

        $inquiry->update([
            'mode' => $request->input('mode'),
            'commodity' => $request->input('commodity'),
            'pickup_date' => $request->input('pickup_date'),
            'priority' => $request->input('priority'),
            'cargo_type' => $request->input('cargo_type'),
            'shipment_address_id' => $shipmentAddressId,
            'supplier_address_id' => $pickupAddressId,
            'delivery_address_id' => $deliveryAddressId,
            'incoterms' => $request->input('incoterms'),
            'pickup_reference' => $request->input('pickup_reference'),
            'notes' => $request->input('notes'),
            'ip' => $userIp,
            'user_agent' => $userAgent,
            'customer_user_id' => auth()->user()->id,
        ]);

        $measurementsData = $request->input('measurements');
        foreach ($measurementsData as $measurementData) {
            $inquiry->measurements()->updateOrCreate(
                [
                    'measurementable_id' => $inquiry->id,
                    'measurementable_type' => Inquiry::class,
                ],
                [
                    'weight' => $measurementData['weight'],
                    'width' => $measurementData['width'],
                    'height' => $measurementData['height'],
                    'length' => $measurementData['length'],
                    'quantity' => $measurementData['quantity'],
                    'dimension_unit' => $measurementData['dimension_unit'],
                    'weight_unit' => $measurementData['weight_unit'],
                ]
            );
        }

        SendInquiryNotification::dispatch($inquiry);

        return redirect()->route('inquiries.index', $inquiry->id);
    }

    private function generateUniqueReferenceNo()
    {
        $prefix = 'EF-';
        $timestamp = time();

        $lastReferenceNoId = ReferenceNo::max('id');
        $referenceNoId = $lastReferenceNoId + 1;

        $referenceNo = $prefix . $timestamp . '-' . $referenceNoId;

        ReferenceNo::create([
            'reference_no' => $referenceNo
        ]);

        return [
            'id' => $referenceNoId,
            'reference_no' => $referenceNo,
        ];
    }
}
