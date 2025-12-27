@extends('layouts.admin')

@section('content')
<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Quotations</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('customer.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        List Quotations
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">Quotations</h4>
    </div>
    <div class="pb-20">
        <table class="data-table table stripe hover nowrap">
            <thead>
                <tr>
                    <th>Reference No</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Weight</th>
                    <th>Cargo Type</th>
                    <th>Status</th>
                    <th class="datatable-nosort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($quotations as $quotation)
                <tr>
                    <td>{{ $quotation->referenceNo->reference_no ?? '' }}</td>
                    <td>{{ $quotation->from }}</td>
                    <td>{{ $quotation->to }}</td>
                    <td>{{ $quotation->weight }}</td>
                    <td>
						@if(isset($quotation->cargo_type))
							{{ constants('cargo_type')[$quotation->cargo_type] ?? 'N/A' }}
						@else
							N/A
						@endif
					</td>
                    <td>
                        @php
                            $statusLabel = constants('quotation_status.' . $quotation->status) ?? 'Unknown';
                            $badgeClass = $quotation->status == 1 ? 'success' : ($quotation->status == 2 ? 'warning' : ($quotation->status == 3 ? 'danger' : 'info'));
                        @endphp
                        <span class="badge badge-{{ $badgeClass }}">{{ $statusLabel }}</span>
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                                type="button" data-toggle="dropdown">
                                <i class="dw dw-more"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                <a class="dropdown-item" href="{{ route('quotations.show', $quotation->id) }}"><i
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
@endsection