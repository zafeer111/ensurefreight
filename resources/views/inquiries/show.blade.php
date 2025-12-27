@extends('layouts.admin')

@section('content')

    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="title">
                        <h4>Inquiries</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('customer.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                <a href="{{ route('inquiries.index') }}">Inquiries</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Inquiry
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="faq-wrap">
            <div class="padding-bottom-30">

                @if ($inquiry->status == 'Answered')
                    <div class="card">
                        <div class="card-header">
                            <button class="btn btn-block" data-toggle="collapse" data-target="#faq0-0">
                                Quotation
                            </button>
                        </div>
                        <div id="faq0-0" class="collapse show">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th><strong>Carrier Name</strong></th>
                                                <th><strong>Rates</strong></th>
                                                <th><strong>Status</strong></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($inquiry->quotation->quotationLineItems as $item)
                                            <tr>
                                                <td>{{ $item->carrier->carrier_name ?? 'N/A' }}</td>
                                                <td>{{ $item->rate_per_kg ?? 'N/A' }}/KG</td>
                                                <td>
                                                    @php
                                                        $statusLabel = constants('quotation_status.' . $item->status) ?? 'Unknown';
                                                        $badgeClass = $item->status == 1 ? 'success' : ($item->status == 2 ? 'warning' : ($item->status == 3 ? 'danger' : 'info'));
                                                    @endphp
                                                    <span class="badge badge-{{ $badgeClass }}">{{ $statusLabel }}</span>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="3">No data available</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                    
                <div class="card">
                    <div class="card-header">
                        <button
                                class="btn btn-block"
                                data-toggle="collapse"
                                data-target="#faq1-1"
                        >
                            Classifications
                        </button>
                    </div>
                    <div id="faq1-1" class="collapse show">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong for="commodity">Item Description</strong>
                                        <div>{{$inquiry->commodity}}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong for="incoterms">Incoterms</strong>
                                        <div>{{$inquiry->incoterms}}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong for="cargo_type">Tariff Segment</strong>
                                        @foreach ($cargo_type as $key => $value)
                                            @if ($key == $inquiry->cargo_type)
                                                <div>{{ $value }}</div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong for="mode">Mode</strong>
                                        @foreach ($mode as $key => $value)
                                            @if ($key == $inquiry->mode)
                                                <div>{{ $value }}</div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong for="pickup_date">Pickup Date</strong>
                                        <div>{{ $inquiry->pickup_date ?? 'N/A' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong for="user_reference_number">Inquiry Reference No</strong>
                                        <div>{{ $inquiry->user_reference_number ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card">
                    <div class="card-header">
                        <button
                                class="btn btn-block"
                                data-toggle="collapse"
                                data-target="#faq2-2"
                        >
                            Broker Details
                        </button>
                    </div>
                    <div id="faq2-2" class="collapse show">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong for="broker_company_name">Broker Company Name</strong>
                                        <div>{{ $inquiry->brokerDetail->company_name ?? 'N/A' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong for="contact_name">Contact Name</strong>
                                        <div>{{ $inquiry->brokerDetail->contact_name ?? 'N/A' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong for="phone">Phone No</strong>
                                        <div>{{ $inquiry->brokerDetail->phone ?? 'N/A' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong for="email">Email Address</strong>
                                        <div>{{ $inquiry->brokerDetail->email ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <button
                                class="btn btn-block"
                                data-toggle="collapse"
                                data-target="#faq3-3"
                        >
                            Pickup Address
                        </button>
                    </div>
                    <div id="faq3-3" class="collapse show">
                        <div class="card-body">
                            <div class="row">
                                <br>

                                <div class="col-md-12">
                                    <h5>Country/Region</h5>
                                </div>
                                <br>
                                <br>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <strong for="country_name">Country Name</strong>
                                        <div>{{ $inquiry->pickupAddress->country->name ?? '' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <strong for="state_name">State Name</strong>
                                        <div>{{ $inquiry->pickupAddress->state->name ?? '' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <strong for="city_name">City Name</strong>
                                        <div>{{ $inquiry->pickupAddress->city->name ?? '' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <strong for="postal_code">Postal Code</strong>
                                        <div>{{ $inquiry->pickupAddress->postal_code ?? '' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <strong for="supplier_address">Pickup Address</strong>
                                        <div>{{ $inquiry->pickupAddress->address ?? '' }}</div>
                                    </div>
                                </div>

                                <br>

                                <div class="col-md-12">
                                    <h5>Contact Information</h5>
                                </div>
                                <br>
                                <br>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <strong for="contact_person_no">Contact Person Name</strong>
                                        <div>{{ $inquiry->pickupAddress->contact_name ?? '' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <strong for="contact_person_email">Contact Email Address</strong>
                                        <div>{{ $inquiry->pickupAddress->contact_email ?? 'N/A' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <strong for="phone_number">Phone No</strong>
                                        <div>{{ $inquiry->pickupAddress->phone_number ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <button
                                class="btn btn-block"
                                data-toggle="collapse"
                                data-target="#faq3-3"
                        >
                            Delivery Address
                        </button>
                    </div>
                    <div id="faq3-3" class="collapse show">
                        <div class="card-body">
                            <div class="row">
                                <br>
                                <br>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <strong for="country_name">Destination Airport IATA</strong>
                                        <br>
                                        <br>
                                        <div>{{ $inquiry->dest_iata ?? 'N/A' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <strong for="state_name">Destination Postal/Zip Code</strong>
                                        <br>
                                        <br>
                                        <div>{{ $inquiry->destination_postal_code ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <button
                                class="btn btn-block"
                                data-toggle="collapse"
                                data-target="#faq6-6"
                        >
                            Measurements
                        </button>
                    </div>
                    <div id="faq6-6" class="collapse show">
                        <div class="card-body">
                            <div class="row">
                                <table class="table text-center">
                                    <thead>
                                    <tr>
                                        <th><strong> Quantity</strong></th>
                                        <th><strong> Dimension Unit</strong></th>
                                        <th><strong> Length</strong></th>
                                        <th><strong> Width</strong></th>
                                        <th><strong> Height</strong></th>
                                        <th><strong> Weight Unit</strong></th>
                                        <th><strong> Weight</strong></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($inquiry->measurements as $measurement)
                                        <tr>
                                            <td>{{ $measurement['quantity'] }}</td>
                                            <td>
                                                @foreach ($dimension_unit as $key => $value)
                                                    @if ($key == $measurement['dimension_unit'])
                                                        {{ $value }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>{{ $measurement['length'] }}</td>
                                            <td>{{ $measurement['width'] }}</td>
                                            <td>{{ $measurement['height'] }}</td>
                                            <td>
                                                @foreach ($weight_unit as $key => $value)
                                                    @if ($key == $measurement['weight_unit'])
                                                        {{ $value }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>{{ $measurement['weight'] }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <button
                                class="btn btn-block"
                                data-toggle="collapse"
                                data-target="#faq5-5"
                        >
                            Other Details
                        </button>
                    </div>
                    <div id="faq5-5" class="collapse show">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong for="priority">Priority</strong>
                                        @foreach ($priority as $key => $value)
                                            @if ($key == $inquiry->priority)
                                                <div>{{ $value }}</div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong for="pickup_reference">Pickup Reference</strong>
                                        <div>{{ $inquiry->pickup_reference ?? 'N/A'}}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong for="notes">Notes</strong>
                                        <div>{{ $inquiry->notes ?? 'N/A'}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection