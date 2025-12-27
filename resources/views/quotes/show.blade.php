@extends('layouts.admin')

@section('content')
<div class="min-height-200px">
    <div class="page-header">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="title">
                    <h4>Quotation</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('customer.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="{{ route('quotations.index') }}">Quotations</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Quotation
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="faq-wrap">
        <div class="padding-bottom-30">
            @if ($quotation)
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-block" data-toggle="collapse" data-target="#quotation-info">
                        Quotation Information
                    </button>
                </div>
                <div id="quotation-info" class="collapse show">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Carrier Name</th>
                                        <th>Rates</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($quotation->quotationLineItems as $item)
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
            @else
            <div class="alert alert-danger" role="alert">
                Quotation not found.
            </div>
            @endif
        </div>
    </div>
</div>
@endsection