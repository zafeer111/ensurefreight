@extends('layouts.admin')

@section('content')

    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Address</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('customer.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('addresses.index') }}">Addresses</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Edit Address
                        </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Default Basic Forms Start -->
        <div class="pd-20 card-box mb-30">
            <div class="clearfix">
                <div class="pull-left">
                    <h4 class="text-blue h4">Edit Address</h4>
                </div>
            </div>
            <br>

            <form method="POST" id="editAddressForm" action="{{ route('addresses.update', $address->id) }}">
                @csrf
                @method('PUT')

                <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label">Full Name<span style="color: red;">*</span></label>
                    <div class="col-sm-12 col-md-10">
                        <input class="form-control" type="text"
                               name="contact_name" id="contact_name"
                               value="{{ $address->contact_name }}"
                               placeholder="Write Full Name here." />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label">Email</label>
                    <div class="col-sm-12 col-md-10">
                        <input class="form-control" type="email"
                               name="contact_email" id="contact_email"
                               value="{{ $address->contact_email }}"
                               placeholder="example@ensurefreight.com" />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label">Contact Number</label>
                    <div class="col-sm-12 col-md-10">
                        <input class="form-control"
                               name="phone_number" id="phone_number"
                               value="{{ $address->phone_number }}"
                               placeholder="Enter contact number" />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label">Country<span style="color: red;">*</span></label>
                    <div class="col-sm-12 col-md-10">
                        <select name="country_id" id="country_id" class="form-control">
                            <option value="">Select a Country</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}" {{ $address->country_id == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label">State<span style="color: red;">*</span></label>
                    <div class="col-sm-12 col-md-10">
                        <select name="state_id" id="state_id" class="form-control">
                            <option value="">Select a State</option>
                            @if (isset($states))
                                @foreach ($states as $state)
                                    <option value="{{ $state->id }}" {{ $address->state_id == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label">City<span style="color: red;">*</span></label>
                    <div class="col-sm-12 col-md-10">
                        <select name="city_id" id="city_id" class="form-control">
                            <option value="">Select a City</option>
                            @if (isset($cities))
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}" {{ $address->city_id == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label">Postal Code<span style="color: red;">*</span></label>
                    <div class="col-sm-12 col-md-10">
                        <input class="form-control"
                               name="postal_code" id="postal_code"
                               value="{{ $address->postal_code }}"
                               placeholder="Enter Postal Code" />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label">Address<span style="color: red;">*</span></label>
                    <div class="col-sm-12 col-md-10">
                        <textarea class="form-control"
                                  id="address" name="address"
                                  rows="4" cols="10"
                                  placeholder="Write Address here.">
                        {{ $address->address }}
                        </textarea>
                    </div>
                </div>
                <!-- Update button -->
                <div class="form-group row">
                    <div class="col-md-10 offset-md-2">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('script')

<!-- Include SweetAlert library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('vendors/scripts/get-states.js') }}"></script>

<script>
    $(document).ready(function () {
        $('#editAddressForm').on('submit', function (e) {
            e.preventDefault();

            // Perform client-side validation
            if ($(this).valid()) {
                // Show SweetAlert confirmation
                showConfirmationDialog($(this));
            }
        });

        // Function to show the SweetAlert confirmation dialog
        function showConfirmationDialog(form) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to update this address!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, update it!',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    // If the user clicks "Yes, update it!", submit the form
                    submitForm(form);
                }
            });
        }

        // Function to submit the form via AJAX
        function submitForm(form) {
            var url = form.attr('action');

            $.ajax({
                type: 'POST',
                url: url,
                data: form.serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    showCustomSuccessDialog(response.message);

                    setTimeout(function () {
                        window.location.href = '{{ route("addresses.index") }}';
                    }, 2000);
                },
                error: function (error) {
                    console.log(error.responseJSON);
                    // Handle validation errors or other errors
                }
            });
        }

        // Function to show the custom success dialog
        function showCustomSuccessDialog(message) {
            Swal.fire({
                title: 'Success!',
                text: message,
                icon: 'success',
                position: 'center',
                showConfirmButton: false,
                timer: 2000
            });
        }

        // Initialize jQuery Validation Plugin
        $('#editAddressForm').validate({
            rules: {
                contact_name: 'required',
                country_id: 'required',
                state_id: 'required',
                city_id: 'required',
                postal_code: 'required',
                address: 'required',
            },
            messages: {
                contact_name: 'Please enter your full name',
                country_id: 'Please select a country.',
                state_id: 'Please select a state.',
                city_id: 'Please select a city.',
                postal_code: 'Postal code is required.',
                address: 'Address is required.',
            }
        });
    });
</script>

@endpush
