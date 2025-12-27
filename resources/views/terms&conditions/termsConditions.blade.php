@extends('layouts.admin')

@push('style')
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .ul1 {
            list-style-type: none;
            padding: 0;
        }
        .li1 {
            margin-bottom: 10px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
    </style>
@endpush

@section('content')
<div class="container">
    <h1>Special Conditions Price Construction</h1>
    <ul class="ul1" style="margin-top: 20px">
        <li class="li1">1. Pick up Conditions (please advise in query)</li>
        <li class="li1">2. Air Freight +++ (refer airline’s additional charges based on the requirement of freight)</li>
        <li class="li1">3. Export Custom Filing</li>
        <li class="li1">4. Insurance Charges</li>
        <li class="li1">5. Chamber Attestation of COO, CI and PL</li>
        <li class="li1">6. Dangerous Goods Declaration and Certification</li>
        <li class="li1">7. Accidental Charges e.g.
            <ul style="list-style-type: lower-alpha; padding-left: 40px; margin-top: 20px">
                <li class="li1">Secondary Screening and Transfer of Freight</li>
                <li class="li1">Repackaging of Damaged Goods</li>
                <li class="li1">Resize of skids</li>
                <li class="li1">New Palletizing</li>
                <li class="li1">New Crating</li>
                <li class="li1">Labeling</li>
                <li class="li1">C6, Re-icing, etc.</li>
                <li class="li1">Amendment of Weight and Customer Information after pick up</li>
                <li class="li1">Amendment of paperwork, labeling, Customer Information after Departure</li>
                <li class="li1">Dead Attempt for Pick up and Delivery</li>
                <li class="li1">Return Shipment after pick up</li>
                <li class="li1">Liftgate Special Equipment</li>
                <li class="li1">Non-stackable</li>
            </ul>
        </li>
    </ul>
</div>
@endsection
