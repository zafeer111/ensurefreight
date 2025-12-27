@extends('layouts.login-main')

@section('content')

<div class="container">
				<div class="row align-items-center">
					<div class="col-md-6">
						<img src="{{ asset('vendors/images/air-freight-logistics.png') }}" alt="" />
					</div>
					<div class="col-md-6">
						<div class="login-box bg-white box-shadow border-radius-10">
							<div class="login-title">
								<h2 class="text-center text-primary">Forgot Password</h2>
							</div>
							<h6 class="mb-20">
								Enter your email address to reset your password
							</h6>
							<form method="POST" action="{{ route('password.email') }}">
								@csrf
								<div class="input-group custom">
									<input
										type="email"
										class="form-control form-control-lg @error('email') is-invalid @enderror"
										name="email"
										value="{{ old('email') }}"
										placeholder="Email"
									/>
									<div class="input-group-append custom">
										<span class="input-group-text"
											><i class="fa fa-envelope-o" aria-hidden="true"></i
										></span>
									</div>

									@error('email')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror

								</div>
								<div class="row align-items-center">
									<div class="col-5">
										<div class="input-group mb-0">
											<!--
											use code for form submit
											<input class="btn btn-primary btn-lg btn-block" type="submit" value="Submit">
										-->
											<!-- <a
												class="btn btn-primary btn-lg btn-block"
												href="index.html"
												>Submit</a
											> -->
											<button type="submit" class="btn btn-primary btn-lg btn-block">
												{{ __('Submit') }}
											</button>
										</div>
									</div>
									<div class="col-2">
										<div
											class="font-16 weight-600 text-center"
											data-color="#707373"
										>
											OR
										</div>
									</div>
									<div class="col-5">
										<div class="input-group mb-0">
											<a
												class="btn btn-outline-primary btn-lg btn-block"
												href="{{ route('customer.login') }}"
												>Login</a
											>
										</div>
									</div>
								</div>
							</form>

							@if (session('status'))
								<div class="mt-3 alert alert-success" role="alert">
									{{ session('status') }}
								</div>
							@endif
							
						</div>
					</div>
				</div>
			</div>

@endsection