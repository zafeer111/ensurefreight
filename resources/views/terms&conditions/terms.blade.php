@extends('layouts.admin')

@push('style')
    <style>

body {
    font-family: 'Arial', sans-serif;
    background-color: #f7f7f7;
    color: #333;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-top: 10px;
}

h1 {
    color: #333;
    margin-top: 10px;
}

h2 {
    color: #555;
    margin-top: 15px;
}

p {
    line-height: 1.6;
    margin-left: 10px;
}

.uL {
    list-style-type: circle;
    padding: 0;
    margin-left: 20px;
    margin-top: 10px;
}

.lI {
    margin-bottom: 5px;
    margin-left: 20px;
    margin-top: 10px;
}

    </style>
@endpush


@section('content')
    <div class="pd-20 card-box mb-30">
        <h1>Terms & Conditions</h1>

        <p>Above pricing includes ex-works from USA and Canada.</p>
        <p>Flight schedule and rates are based on currently availability. Currently, no carrier / GSA is providing validity unless shipment is confirmed under assigned AWB #.</p>
        <p>Rates not valid for Dangerous Goods, Temperature Control, Perishable, Live Stock. Please check spot rates.</p>
        <p>Transit time is not guaranteed as per all the carriers advisements.</p>
        <p>No claim and or dispute about weight discrepancy would be accepted after shipment has arrived at the airport of destination.</p>
        <p>Weight correction charges $ 25 as per carrier.</p>
        <p>Revised AWB instructions after pick up $ $ 25.</p>
        <p>Change of Labeling $ 50.</p>
        
        <h2>Credit Terms:</h2>
        <p>Client’s 30 days begins from the date of shipment’s initiation/pick up/BOL/Booking. The same appears as Invoice Date as well as Shipment Date on each freight invoice.</p>
        <p>Service Date shows flight number and date departure and arrival information.</p>

        <h2>Late Payments:</h2>
        <ul class="uL">
            <li class="lI">3 days would cost you @ $ 0.10% of freight invoice.</li>
            <li class="lI">5 days would cost you @ $ 1% of freight invoice plus Observation Alert.</li>
            <li class="lI">10 days would cost you @ $ 1.50% of freight invoice plus Credit Hold in Effect.</li>
        </ul>
    </div>
@endsection
