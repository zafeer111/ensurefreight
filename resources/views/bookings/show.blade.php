@extends('layouts.admin')

@section('content')

<div class="min-height-200px">
    <div class="page-header">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="title">
                    <h4>Bookings</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('customer.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="{{ route('bookings.index') }}">Bookings</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Booking
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="faq-wrap">
        <div class="padding-bottom-30">
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-block" data-toggle="collapse" data-target="#faq0-0">
                        Booking Details
                    </button>
                </div>
                <div id="faq0-0" class="collapse show">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>Carrier</strong>
                                    <div>{{ $booking->carrier->carrier_name }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>Tariff Rate</strong>
                                    <div>{{ $booking->tariff_rate }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>Rate Per KG</strong>
                                    <div>{{ $booking->rate_per_kg }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>Total Rate</strong>
                                    <div>{{ $booking->total_rate }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>Status</strong>
                                    <div>{{ isset(constants('booking_status')[$booking->status]) ? constants('booking_status')[$booking->status] : 'Unknown' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>Created At</strong>
                                    <div>{{ $booking->created_at }}</div>
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