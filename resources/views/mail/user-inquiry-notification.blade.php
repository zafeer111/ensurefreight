<x-mail::message>
# Inquiry Created Successfully
    

<x-mail::subcopy>
    Inquiry Ref #{{ $inquiry->referenceNo->reference_no ?? '' }}
</x-mail::subcopy>

**Commodity:** {{ $inquiry->commodity }}
<br>
**Cargo Type:** @if(isset($inquiry->cargo_type)) {{ constants('cargo_type')[$inquiry->cargo_type] ?? 'N/A' }} @endif

@php
$totalWeight = 0;
$totalSkids = 0;
@endphp

@foreach ($inquiry->measurements as $measurement)
    @php
    $totalWeight += $measurement->weight;
    $totalSkids += $measurement->quantity;
    @endphp

    **Dimensions:** {{ $measurement->height }} x {{ $measurement->width }} x {{ $measurement->length }} {{ config('constants.dimension_unit')[$measurement->dimension_unit] ?? 'N/A' }}
@endforeach

{{-- Display total skids and total gross weight --}}
**Skids:** {{ $totalSkids }}
<br>
**Total Gross Weight:** {{ $totalWeight }} {{ config('constants.weight_unit')[$measurement->weight_unit] ?? 'N/A' }}

<x-mail::table>
| Carrier Name       | Rate         |
| ------------- |:-------------:| 
@foreach ($inquiry->quotation->quotationLineItems as $item)
| {{ $item->carrier->carrier_name ?? 'N/A' }}      | {{ $item->rate_per_kg ?? 'N/A' }} /KG      |
@endforeach
</x-mail::table>

<x-mail::button :url="route('inquiries.show', $inquiry->id)" color="success">
View Inquiry
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}

<x-mail::footer>
<div class="footer-wrap pd-20 mb-20 card-box">
    <a target="_blank" style="color: red; text-decoration: none;" href="https://www.ensurefreightinc.com/">Ensure Freight Inc</a>- OnlineApp, <br/>
    <span class="italic small">Powered by</span>
    <a class="small" href="https://widewebartisans.com/" target="_blank">Wide Web Artisans</a>
</div>
</x-mail::footer>
</x-mail::message>
