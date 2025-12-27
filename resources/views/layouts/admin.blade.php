<!DOCTYPE html>
<html>
	<head>
		<!-- Basic Page Info -->
		<meta charset="utf-8" />
		<title>Ensure Freight</title>

	

		<!-- Mobile Specific Metas -->
		<meta
			name="viewport"
			content="width=device-width, initial-scale=1, maximum-scale=1"
		/>

		<!-- Google Font -->
		<link
			href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
			rel="stylesheet"
		/>
		<!-- CSS -->
		<link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/core.css') }}" />
		<link
			rel="stylesheet"
			type="text/css"
			href="{{ asset('vendors/styles/icon-font.min.css') }}"
		/>
		<link
			rel="stylesheet"
			type="text/css"
			href="{{ asset('src/plugins/datatables/css/dataTables.bootstrap4.min.css') }}"
		/>
		<link
			rel="stylesheet"
			type="text/css"
			href="{{ asset('src/plugins/datatables/css/responsive.bootstrap4.min.css') }}"
		/>
		<link
			rel="stylesheet"
			type="text/css"
			href="{{ asset('src/plugins/apexcharts/apexcharts.css') }}"
		/>
		<link
			rel="stylesheet"
			type="text/css"
			href="{{ asset('src/plugins/jquery-steps/jquery.steps.css') }}"
		/>
		<link
			rel="stylesheet"
			type="text/css"
			href="{{ asset('src/plugins/sweetalert2/sweetalert2.css') }}"
		/>
		<link
		rel="stylesheet"
		type="text/css"
		href="{{ asset('vendors/styles/style.css') }}"
		/>
		<link
		rel="stylesheet"
		type="text/css"
		href="{{ asset('vendors/styles/select.css') }}"
		/>

		<meta name="csrf-token" content="{{ csrf_token() }}">

		@stack('style')

	</head>
	<body class="header-white sidebar-light">

		@include('layouts.header')


		@include('layouts.side-menu')

		<div class="mobile-menu-overlay"></div>


        <!-- main container -->
		<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">

				@yield('content')

				<div class="footer-wrap pd-20 mb-20 card-box">
					<a target="_blank" style="color :red;   text-decoration: none; " href="https://www.ensurefreightinc.com/">Ensure Freight Inc</a>- OnlineApp, <br/><span class="italic small">Powered by</span>
					<a class="small" href="https://widewebartisans.com/" target="_blank"
					>Wide Web Artisans</a
					>
				</div>

			</div>

        </div>

		<!-- js -->
		<script src="{{ asset('vendors/scripts/core.js') }}"></script>
		<script src="{{ asset('vendors/scripts/script.min.js') }}"></script>
		<script src="{{ asset('vendors/scripts/process.js') }}"></script>
		<script src="{{ asset('vendors/scripts/layout-settings.js') }}"></script>
		<script src="{{ asset('src/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
		<script src="{{ asset('src/plugins/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
		<script src="{{ asset('src/plugins/datatables/js/dataTables.responsive.min.js') }}"></script>
		<script src="{{ asset('src/plugins/datatables/js/responsive.bootstrap4.min.js') }}"></script>
		<!-- <script src="{{ asset('vendors/scripts/dashboard3.js') }}"></script> -->


		<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>

		<script src="{{ asset('src/plugins/sweetalert2/sweetalert2.all.js') }}"></script>
		<script src="{{ asset('src/plugins/sweetalert2/sweet-alert.init.js') }}"></script>


		<script>
			Notify = function(text = 'Success', type = 'success') {
				let basic = {globalPosition: 'bottom right', className : type,   arrowShow: true, arrowSize: 5, gap: 10};
				$.notify(text, basic);
			}
		</script>
		<script src="{{ asset('vendors/scripts/datatable-setting.js') }}"></script>
		<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
		<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
		@stack('script')
	</body>
</html>
