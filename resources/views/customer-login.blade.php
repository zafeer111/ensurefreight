@extends('layouts.login-main')

@section('content')

<div class="container">
    <div class="row align-items-center">
        <div class="col-md-6 col-lg-7">
            <img src="{{ asset('vendors/images/air-freight-logistics.png') }}" alt="" />
        </div>
        <div class="col-md-6 col-lg-5">
            <div class="login-box bg-white box-shadow border-radius-10">
                <div class="login-title">
                    <h2 class="text-center text-primary">Customer Login</h2>
                </div>
                <form method="POST" action="{{ route('customer.login') }}">
                    @csrf
                    @method('POST')
                    
                    @if($errors->has('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ $errors->first('error') }}
                        </div>
                    @endif
                    
                    <div class="input-group custom">
                        <input
                            type="email"
                            class="form-control form-control-lg"
                            name="email"
                            placeholder="Email"
                        />
                        <div class="input-group-append custom">
                            <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                        </div>
                    </div>
                    <div class="input-group custom">
                        <input
                            type="password"
                            name="password"
                            class="form-control form-control-lg password-field"
                            placeholder="**********"
                        />
                        <div class="input-group-append custom">
                            <span class="input-group-text toggle-password" style="cursor: pointer;"><i class="dw dw-eye"></i></span>
                        </div>
                    </div>
                    <div class="row pb-30">
                        <div class="col-6">
                            <div class="custom-control custom-checkbox">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="customCheck1"
                                />
                                <label class="custom-control-label" for="customCheck1">Remember</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="forgot-password">
                                <a href="{{ route('password.request') }}">Forgot Password</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="input-group mb-0">
                                <input class="btn btn-primary btn-lg btn-block" type="submit" value="Sign In">
                            </div>
                            <div class="font-16 weight-600 pt-10 pb-10 text-center" data-color="#707373">OR</div>
                            <div class="input-group mb-0">
                                <button class="btn btn-outline-primary btn-lg btn-block" disabled data-toggle="tooltip" data-placement="top" title="Coming soon">Continue as Guest</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

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