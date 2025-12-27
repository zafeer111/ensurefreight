<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Quote</title>
    <style>
        .margin-top-li {
            margin-top: 50px;
        }
        img{
            max-width: 10%;
            margin-top: 20px;
        }
    </style>
</head>
<body>

@php
$totalWeight = 0;
$totalSkids = 0;
@endphp

@foreach ($inquiry->measurements as $measurement)
    @php
    $totalWeight += $measurement->weight;
    $totalSkids += $measurement->quantity;
    @endphp
@endforeach

<div>
    <p>Dear Sir,</p>
</div>
<div>
    <ul>
    @foreach ($inquiry->quotation->quotationLineItems as $item)

    <li class="margin-top-li">Based on {{$totalSkids}}, stackable, minimum chargeable {{$totalWeight}} KG to {{$inquiry->quotation->to}} @ USD$ {{ $item->rate_per_kg ?? 'N/A' }}/kg on {{ $item->carrier->carrier ?? 'N/A' }} transit time  4 - 5 business days.</li>
    
    @endforeach
    </ul>
</div>

<div style="margin-top: 20px">
    <ul>
        <li>Above pricing includes ex-works from USA and Canada.</li>
        <li>Flight schedule and rates are based on currently availability. Currently, no carrier / GSA is providing validity unless shipment is confirmed under assigned AWB #.</li>
        <li>Rates not valid for Dangerous Goods, Temperature Control, Perishable, Live Stock. Please check spot rates.</li>
        <li>Transit time is not guaranteed as per all the carriers advisements.</li>
        <li>No claim and or dispute about weight discrepancy would be accepted after shipment has arrived at the airport of destination.</li>
        <li>Weight correction charges $ 25 as per carrier.</li>
        <li>Revised AWB instructions after pick up $ $ 25.</li>
        <li>Change of Labeling $ 50.</li>
    </ul>
</div>
<div style="margin-top: 30px">
    <p style="text-decoration: underline">Credit Terms: </p>
    <ul>
        <li>Client’s 30 days begins from the date of shipment’s initiation/pick up/BOL/Booking. The same appears as Invoice Date as well as Shipment Date on each freight invoice.</li>
        <li>Service Date shows flight number and date departure and arrival information.</li>
        <li>Late Payments would come to you @ cost per below stipulation:</li>
        <ul style="list-style-type: circle; margin-top: 10px">
            <li>3 days would cost you @ $ 0.10% of freight invoice.</li>
            <li>5 days would cost you @ $ 1% of freight invoice plus Observation Alert.</li>
            <li>10 days would cost you @ $ 1.50% of freight invoice plus Credit Hold in Effect.</li>
        </ul>
    </ul>
</div>
<div>
    <p style="text-decoration: underline;"><i>Always copy:</i></p>
    <a href="mailto:bookings@ensurefreightinc.com" style="text-decoration: underline; color: black">bookings@ensurefreightinc.com</a>

</div>
<div style="font-family: 'Brush Script MT', cursive">
    <p>Regards,</p>
    <h3>Mohammad Siddiqui</h3>
    <p style="margin-top: 10px">Tel: +1-647-9893150</p>
    <p style="margin-top: 10px">Ensure Freight Inc.</p>
</div>
    <a href="https://app.ensurefreightinc.com/customer-login">www.app.ensurefreightinc.com</a>

</body>
</html>