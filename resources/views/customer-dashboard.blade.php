@extends('layouts.admin')

@section('content')

@push('style')
<style>
	.banner-section {
		background: linear-gradient(145deg, #3f51b5, #2196f3);
		box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.3);
		width: 100%;
		padding: 20px;
		border-radius: 10px !important;
	}

	.banner {
		transition: transform 0.3s ease-in-out;
		box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.2);
		border-radius: 5px !important;
	}

	.banner:hover {
		transform: scale(1.03);
	}

	.banner-animation {
		animation: banner-float 3s ease-in-out infinite alternate;
	}

	@keyframes banner-float {
		0% {
			transform: translateY(0);
		}

		100% {
			transform: translateY(-10px);
		}
	}

	.banner .btn-light {
		background-color: #ff5722;
		border-color: #ff5722;
		color: #ffffff;
	}

	.banner .btn-light:hover {
		background-color: #f4511e;
		border-color: #f4511e;
		color: #ffffff;
		box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
		transform: translateY(-2px);
	}
</style>
@endpush

@php
// Get the authenticated user
$user = auth()->user();

// Get the count of inquiries created by the user
$inquiryCount = App\Models\Inquiry::where('customer_user_id', $user->id)->count();

@endphp

<div class="xs-pd-20-10">
	<div class="title pb-20">
		<h2 class="h3 mb-0">Ensure Freight Overview</h2>
	</div>

	<!-- Banner Section -->
	<div class="banner-section mt-10 mb-30">
		<div class="row justify-content-center align-items-center">
			<div class="col-12">
				<div class="banner text-center text-white rounded p-4 banner-animation">
					<h2 class="banner-title mb-3">Get Your Freight Rates Quickly!</h2>
					<p class="banner-description mb-4">Click below to get started.</p>
					<a href=" {{ route('inquiries.create') }} " class="btn btn-light btn-lg">Get Freight Rates</a>
				</div>
			</div>
		</div>
	</div>

	<div class="row pb-10">
		<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
			<div class="card-box height-100-p widget-style3">
				<div class="d-flex flex-wrap">
					<div class="widget-data">
						<div class="weight-700 font-24 text-dark"> {{ $inquiryCount }} </div>
						<div class="font-14 text-secondary weight-500">
							Inquires
						</div>
					</div>
					<div class="widget-icon">
						<div class="icon" data-color="#00eccf">
							<i class="icon-copy dw dw-question"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
			<div class="card-box height-100-p widget-style3">
				<div class="d-flex flex-wrap">
					<div class="widget-data">
						<div class="weight-700 font-24 text-dark">0</div>
						<div class="font-14 text-secondary weight-500">
							Total Invoices
						</div>
					</div>
					<div class="widget-icon">
						<div class="icon" data-color="#ff5b5b">
							<span class="icon-copy ti-files"></span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
			<div class="card-box height-100-p widget-style3">
				<div class="d-flex flex-wrap">
					<div class="widget-data">
						<div class="weight-700 font-24 text-dark">{{ $sessionStartTime }}</div>
						<div class="font-14 text-secondary weight-500">
							Last Login
						</div>
					</div>
					<div class="widget-icon">
						<div class="icon">
							<i class="icon-copy fa fa-calendar-times-o" aria-hidden="true"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
			<div class="card-box height-100-p widget-style3">
				<div class="d-flex flex-wrap">
					<div class="widget-data">
						<div class="weight-700 font-24 text-dark">0</div>
						<div class="font-14 text-secondary weight-500">Total Shipment</div>
					</div>
					<div class="widget-icon">
						<div class="icon" data-color="#09cc06">
							<i class="icon-copy fa fa-ship" aria-hidden="true"></i>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>

	<div class="row pb-10">
		<div class="col-md-8 mb-20">
			<div class="card-box height-100-p pd-20">
				<div class="d-flex flex-wrap justify-content-between align-items-center pb-0 pb-md-3">
				</div>
				<div class="h5 mb-md-0">Inquires Activities</div>
				<div id="chart3" data-url="{{ route('dashboard.chart') }}"></div>
			</div>
		</div>

		<div class="col-md-4 mb-20">

		</div>
	</div>

</div>

@endsection

@push('script')

<script src="{{ asset('src/plugins/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('vendors/scripts/apexcharts-setting.js') }}"></script>
<script src="{{ asset('vendors/scripts/dashboard3.js') }}"></script>

@endpush