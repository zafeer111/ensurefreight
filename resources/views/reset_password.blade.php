@extends('layouts.login-main')

@section('content')

<div class="container">
    <div class="row align-items-center">
        <div class="col-md-6">
            <img src="{{ asset('vendors/images/forgot-password.png') }}" alt="" />
        </div>
        <div class="col-md-6">
            <div class="login-box bg-white box-shadow border-radius-10">
                <div class="login-title">
                    <h2 class="text-center text-primary">Reset Password</h2>
                </div>
                <h6 class="mb-20">Enter your new password, confirm and submit</h6>
                <form method="POST" action="{{ route('password.update.submit') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <!-- Email Field -->
                <div class="input-group custom">
                    <input
                        type="email"
                        class="form-control form-control-lg @error('email') is-invalid @enderror"
                        name="email"
                        placeholder="Email"
                        value="{{ old('email') }}"
                    />
                    <div class="input-group-append custom">
                        <span class="input-group-text"><i class="dw dw-email"></i></span>
                    </div>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <!-- New Password Field -->
                <div class="input-group custom">
                    <input
                        type="password"
                        class="form-control form-control-lg password-field @error('password') is-invalid @enderror"
                        name="password"
                        placeholder="New Password"
                    />
                    <div class="input-group-append custom">
                        <span class="input-group-text toggle-password" style="cursor: pointer;"><i class="dw dw-eye"></i></span>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <!-- Confirm New Password Field -->
                <div class="input-group custom">
                    <input
                        type="password"
                        class="form-control form-control-lg password-field @error('password_confirmation') is-invalid @enderror"
                        name="password_confirmation"
                        placeholder="Confirm New Password"
                    />
                    <div class="input-group-append custom">
                        <span class="input-group-text toggle-password" style="cursor: pointer;"><i class="dw dw-eye"></i></span>
                    </div>
                    @error('password_confirmation')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <!-- Submit Button -->
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="input-group mb-0 d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                {{ __('Reset Password') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>

                @if (session('status'))
                    <div class="mt-3 alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @if(session('status') == 'Password successfully reset')
                        <script>
                            // Wait for 3 seconds (adjust the delay as needed)
                            setTimeout(function() {
                                // Redirect to the login page
                                window.location.href = "{{ route('customer.login') }}";
                            }, 3000); // 3000 milliseconds = 3 seconds
                        </script>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.toggle-password').click(function() {
            $(this).toggleClass('eye-open');
            var input = $(this).parent().prev('.password-field');
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
            } else {
                input.attr('type', 'password');
            }
        });
    });
</script>

@endsection
