@extends('layouts.admin')

@section('content')

<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Bookings</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('customer.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        List Bookings
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- Simple Datatable start -->
<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">Bookings</h4>
    </div>
    <div class="pb-20">
        <table class="data-table table stripe hover nowrap">
            <thead>
                <tr>
                    <th class="table-plus datatable-nosort">Reference No</th>
                    <th>Carrier</th>
                    <th>Rate Per KG</th>
                    <th>Total Rate</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th class="datatable-nosort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bookings as $booking)
                <tr>
                    <td class="table-plus">{{ $booking->referenceNo->reference_no ?? '' }}</td>
                    <td>{{ $booking->carrier->carrier_name }}</td>
                    <td>{{ $booking->rate_per_kg }}</td>
                    <td>{{ $booking->total_rate }}</td>
                    <td>
						@php
							$statusLabel = isset(constants('booking_status')[$booking->status]) ? constants('booking_status')[$booking->status] : 'Unknown';
							$badgeClass = $booking->status == 1 ? 'success' : ($booking->status == 2 ? 'warning' : ($booking->status == 3 ? 'danger' : 'info'));
						@endphp
						<span class="badge badge-{{ $badgeClass }}">{{ $statusLabel }}</span>
					</td>
                    <td>{{ $booking->created_at }}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                                type="button" data-toggle="dropdown">
                                <i class="dw dw-more"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                <a class="dropdown-item" href="{{ route('bookings.show', $booking->id) }}"><i
                                        class="dw dw-eye"></i> View</a>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- Simple Datatable End -->

@endsection