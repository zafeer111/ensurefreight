@extends('layouts.admin')


@section('content')

<div class="page-header">
	<div class="row">
		<div class="col-md-6 col-sm-12">
			<div class="title">
				<h4>Inquiries</h4>
			</div>
			<nav aria-label="breadcrumb" role="navigation">
				<ol class="breadcrumb">
					<li class="breadcrumb-item">
						<a href="{{ route('customer.dashboard') }}">Dashboard</a>
					</li>
					<li class="breadcrumb-item active" aria-current="page">
						List Inquiries
					</li>
				</ol>
			</nav>
		</div>
	</div>
</div>
<!-- Simple Datatable start -->
<div class="card-box mb-30">
	<div class="pd-20">
		<h4 class="text-blue h4">Inquiries</h4>
	</div>
	<div class="pb-20">
		<table class="data-table table stripe hover nowrap">
			<thead>
				<tr>
					<th>Reference No</th>
					<th class="table-plus datatable-nosort">Commodity</th>
					<th>Mode</th>
					<th>Incoterms</th>
					<th>Cargo Type</th>
					<th>Status</th>
					<th>Created At</th>
					<th class="datatable-nosort">Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($inquiries as $inquiry)
				<tr>
					<td>{{ $inquiry->referenceNo->reference_no ?? '' }}</td>
					<td class="table-plus">{{ $inquiry->commodity }}</td>
					<td>
						@php
							$mode = constants('mode.' . $inquiry->mode, 'Unknown');
						@endphp
						{{ $mode }}
					</td>
					<td>{{ $inquiry->incoterms }}</td>
					<td>
						@php
							$cargoType = constants('cargo_type.' . $inquiry->cargo_type) ?? 'Unknown';
						@endphp

						{{ $cargoType }}

					</td>
					<td>
						@php
							$statusLabel = constants($inquiry->status);
							$statusClass = '';
							switch($statusLabel) {
								case 'Initiate':
									$statusClass = 'badge-info';
									break;
								case 'Answered':
									$statusClass = 'badge-success';
									break;
								case 'Viewed':
									$statusClass = 'badge-secondary';
									break;
								default:
									$statusClass = 'badge-danger';
									break;
							}
						@endphp
    				<span class="badge {{ $statusClass }}">{{ $statusLabel }}</span>
					</td>
					<td>{{ $inquiry->created_at }}</td>
					<td>
						<div class="dropdown">
							<button class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" type="button" data-toggle="dropdown">
								<i class="dw dw-more"></i>
							</button>
							<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
								<a class="dropdown-item" href="{{ route('inquiries.show', $inquiry->id) }}"><i class="dw dw-eye"></i> View</a>

								<!-- @if ($inquiry->status !== 'Answered')
								<a class="dropdown-item" href="{{ route('inquiries.edit', $inquiry->id) }}"><i class="dw dw-edit2"></i> Edit</a>
								@endif -->

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