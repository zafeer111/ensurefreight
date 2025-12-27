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
		<link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/style.css') }}" />
		
	</head>
	<body class="login-page">
		<div class="login-header box-shadow">
			<div
				class="container-fluid d-flex justify-content-between align-items-center"
			>
				<div class="brand-logo">
					<a href="{{ url()->current() }}">
						<img src="{{ asset('vendors/images/new_logo.png') }}" alt="" style="max-width: 250px; max-height: 70px;"/>
					</a>
				</div>
			</div>

		</div>

		<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">

			<div class="container">
					@yield('content')

					
				<div class="bottom-left-button">
						<a href="{{ route('login') }}">
							<button type="button" class="btn btn-primary">CRM Login</button>
						</a>
				</div>

			</div>

		</div>
        
		<!-- js -->
		<script src="{{ asset('vendors/scripts/core.js') }}"></script>
		<script src="{{ asset('vendors/scripts/script.min.js') }}"></script>
		<script src="{{ asset('vendors/scripts/process.js') }}"></script>
		<script src="{{ asset('vendors/scripts/layout-settings.js') }}"></script>
		
	</body>
</html>
