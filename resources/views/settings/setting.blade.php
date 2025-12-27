@extends('layouts.admin')

@section('content')

			<div class="xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<div class="title">
									<h4>Settings</h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb">
										<li class="breadcrumb-item">
											<a href="{{ route('customer.dashboard') }}">Dashboard</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">
											Setting
										</li>
									</ol>
								</nav>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
							<div class="pd-20 card-box height-100-p">
								<div class="profile-photo" 
								style="position: relative; max-width: 300px; max-height: 300px;"
								>
									<a
										href="modal"
										data-toggle="modal"
										data-target="#Medium-modal"
										class="edit-avatar"
										><i class="fa fa-pencil"></i
									></a>
									<img
									src="{{ auth()->user()->user_img ? asset(auth()->user()->user_img) : asset('src/images/default-avatar.jpg') }}"
										alt=""
										class="avatar-photo"
										style="width: 100%; height: auto; display: block; max-width: 100%; max-height: 100%;"
									/>
									<div
										class="modal fade"
										id="Medium-modal"
										tabindex="-1"
										role="dialog"
										aria-labelledby="modalLabel"
										aria-hidden="true"
									>
									<div class="modal-dialog modal-dialog-centered d-flex align-items-center justify-content-center" role="document">
										<div class="modal-content" style="width: 500px;">
											<div class="modal-header">
												<h5 class="modal-title" id="modalLabel">Upload Image</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												<div class="img-container text-center mx-auto" style="max-width: 100%; max-height: 100%;">
													<img id="userImage"
													src="{{ auth()->user()->user_img ? asset(auth()->user()->user_img) : asset('src/images/default-avatar.jpg') }}"
													alt="User Picture"
													class="img-fluid rounded">
												</div>
												<div class="mt-3 text-center">
													<form id="uploadImageForm" action="{{ route('upload.image') }}" method="post" enctype="multipart/form-data" class="text-center">
														@csrf
														<div class="mx-auto d-block">
															<input type="file" name="image" accept="image/*">
														</div>
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
												<button type="submit" class="btn btn-primary" id="saveChangesBtn">Save Changes</button>
												</form>
											</div>
										</div>
									</div>

									</div>
								</div>
								<h5 class="text-center h5 mb-0">{{ auth()->user()->name }}</h5>
								<p class="text-center text-muted font-14">
									{{ auth()->user()->customer->name }}
								</p>
								<div class="profile-info">
									<h5 class="mb-20 h5 text-blue">Company Information</h5>
									<ul>
										<li>
											<span>Email Address:</span>
											{{ auth()->user()->customer->email }}
										</li>
										<li>
											<span>Address:</span>
											{{ auth()->user()->customer->address }}
										</li>
										<li>
											<div class="user-location">
												<span>Country:</span>
												{{ auth()->user()->customer->country->name }}
											</div>
										</li>
										<li>
											<span>Postal Code:</span>
											{{ auth()->user()->customer->postal_code }}
										</li>
									</ul>
								</div>
							</div>
						</div>
						<div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
							<div class="card-box height-100-p overflow-hidden">
								<div class="profile-tab height-100-p">
									<div class="tab height-100-p">
										<ul class="nav nav-tabs customtab" role="tablist">
											<li class="nav-item">
												<a
													class="nav-link active"
													data-toggle="tab"
													href="#setting"
													role="tab"
													>Settings</a
												>
											</li>
											<li class="nav-item">
												<a
													class="nav-link"
													data-toggle="tab"
													href="#password-reset"
													role="tab"
													>Change Password</a
												>
											</li>
										</ul>
										<div class="tab-content">

										<!-- Setting Tab start -->
										<div
												class="tab-pane fade show active"
												id="setting"
												role="tabpanel"
											>
												<div class="profile-setting">
													<form id="updateProfileForm">
														@csrf
														<ul class="profile-edit-list row">
															<li class="weight-500 col-md-6">
																<div class="form-group">
																	<label>Full Name<span style="color: red;">*</span></label>
																	<input class="form-control form-control-lg" type="text" placeholder="Full Name" name="name" value="{{ auth()->user()->name }}"/>
																</div>
																<div class="form-group">
																	<label>Gender<span style="color: red;">*</span></label>
																	<select name="gender" id="gender" class="form-control" title="Not Chosen">
																		@foreach(['male', 'female', 'other'] as $gender)
																			<option value="{{ $gender }}" {{ old('gender', auth()->user()->gender) == $gender ? 'selected' : '' }}>
																				{{ ucfirst($gender) }}
																			</option>
																		@endforeach
																	</select>
																</div>
																<div class="form-group">
																	<label>Country<span style="color: red;">*</span></label>
																	<select name="country_id" id="country_id" class="form-control">
																		<option value="">Select a Country</option>
																		@foreach ($countries as $country)
																			<option value="{{ $country->id }}" {{ old('country_id', auth()->user()->country_id) == $country->id ? 'selected' : '' }}>
																				{{ $country->name }}
																			</option>
																		@endforeach
																	</select>
																</div>
																<div class="form-group">
																	<label>City<span style="color: red;">*</span></label>
																	<select name="city_id" id="city_id" class="form-control">
																		<option value="">Select a City</option>
																		@if (isset($cities))
																			@foreach ($cities as $city)
																				<option value="{{ $city->id }}" {{ old('city_id', auth()->user()->city_id) == $city->id ? 'selected' : '' }}>
																					{{ $city->name }}
																				</option>
																			@endforeach
																		@endif
																	</select>
																</div>
																<div class="form-group mb-0">
																	<button type="submit" class="btn btn-primary" id="updateProfileBtn">Update</button>
																</div>
															</li>
															<li class="weight-500 col-md-6">
																<div class="form-group">
																	<label>Phone Number<span style="color: red;">*</span></label>
																	<input class="form-control form-control-lg" type="text" placeholder="Phone Number"
																	 name="phone"
																	 value="{{ auth()->user()->phone }}" />
																</div>
																<div class="form-group">
																	<label>Postal Code<span style="color: red;">*</span></label>
																	<input class="form-control form-control-lg" type="text" placeholder="Postal Code"
																	name="postal_code"
																	value="{{ auth()->user()->postal_code }}" />
																</div>
																<div class="form-group">
																	<label>State<span style="color: red;">*</span></label>
																	<select name="state_id" id="state_id" class="form-control">
																		<option value="">Select a State</option>
																		@if (isset($states))
																			@foreach ($states as $state)
																				<option value="{{ $state->id }}" {{ old('state_id', auth()->user()->state_id) == $state->id ? 'selected' : '' }}>
																					{{ $state->name }}
																				</option>
																			@endforeach
																		@endif
																	</select>

																</div>
															</li>
														</ul>
													</form>
											</div>
										</div>
											<!-- Setting Tab End -->

											<!-- Password Reset Tab start -->
											<div class="tab-pane fade height-100-p" id="password-reset" role="tabpanel">
												<div class="profile-setting">
													<form id="passwordResetForm">
														@csrf
														<ul class="profile-edit-list row">
															<li class="weight-500 col-md-6">
																<h4 class="text-blue h5 mb-20">
																	Password Reset
																</h4>
																<div class="form-group">
																	<label>Current Password<span style="color: red;">*</span></label>
																	<div class="input-group">
																		<input id="current_password" class="form-control form-control-lg" type="password" name="current_password" required />
																		<div class="input-group-append">
																			<span class="input-group-text show-password" data-input-id="current_password">
																				<i class="fa fa-eye-slash"></i>
																			</span>
																		</div>
																	</div>
																</div>
																<div class="form-group">
																	<label>New Password<span style="color: red;">*</span></label>
																	<div class="input-group">
																		<input id="new_password" class="form-control form-control-lg" type="password" name="new_password" />
																		<div class="input-group-append">
																			<span class="input-group-text show-password" data-input-id="new_password">
																				<i class="fa fa-eye-slash"></i>
																			</span>
																		</div>
																	</div>
																</div>
																<div class="form-group">
																	<label>Confirm Password<span style="color: red;">*</span></label>
																	<div class="input-group">
																		<input id="confirm_password" class="form-control form-control-lg" type="password" name="confirm_password" />
																		<div class="input-group-append">
																			<span class="input-group-text show-password" data-input-id="confirm_password">
																				<i class="fa fa-eye-slash"></i>
																			</span>
																		</div>
																	</div>
																</div>
																<div class="form-group mb-0">
																	<button type="submit" class="btn btn-primary" id="resetPasswordBtn">Reset Password</button>
																</div>
															</li>
														</ul>
													</form>
												</div>
											</div>
											<!-- Password Reset Tab end -->


										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

@endsection

@push('script')

<script src="{{ asset('vendors/scripts/get-states.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
    $('input[name="image"]').change(function () {
        displayImage(this);
    });

    function displayImage(input) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#userImage').attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }

    $('#uploadImageForm').submit(function (e) {
        e.preventDefault();

        // Client-side validation
        var imageInput = $('input[name="image"]');
        if (imageInput[0].files.length === 0) {
            Swal.fire({
                title: 'Error',
                text: 'Please select an image.',
                icon: 'error',
                showConfirmButton: true
            });
            return;
        }

        var formData = new FormData($(this)[0]);
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('#Medium-modal').modal('hide');
            },
            success: function (response) {
                Swal.fire({
                    title: 'Success',
                    text: response.message,
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function () {
                    location.reload();
                });
            },
            error: function (error) {
                if (error.responseJSON.errors) {
                    // Handle specific validation errors
                    var errorMessage = ' ';
                    $.each(error.responseJSON.errors, function (key, value) {
                        errorMessage += ' ' + value;
                    });

                    Swal.fire({
                        title: 'Error',
                        text: errorMessage,
                        icon: 'error',
                        showConfirmButton: true
                    });
                } else {
                    // Handle other types of errors
                    Swal.fire({
                        title: 'Error',
                        text: 'An error occurred. Please try again.',
                        icon: 'error',
                        showConfirmButton: true
                    });
                }
            }
        });
    });
});


	$(document).ready(function () {
    $('#updateProfileForm').validate({
        rules: {
            name: {
                required: true,
            },
            phone: {
                required: true,
            },
            gender: {
                required: true,
            },
            country_id: {
                required: true,
            },
            state_id: {
                required: true,
            },
            city_id: {
                required: true,
            },
            postal_code: {
                required: true,
            },
        },
        messages: {
            name: {
                required: "Please enter your full name",
            },
            gender: {
                required: "Please select your gender",
            },
            phone: {
                required: "Please enter your phone number",
            },
            country_id: {
                required: "Please select country",
            },
            state_id: {
                required: "Please select state",
            },
            city_id: {
                required: "Please select city",
            },
            postal_code: {
                required: "Please enter your postal code",
            },
        },
    });

    $('#updateProfileBtn').click(function (e) {
        e.preventDefault();

        if ($('#updateProfileForm').valid()) {
			var formData = $('#updateProfileForm').serialize();
			formData += '&_token=' + $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "{{ route('update.profile') }}",
                type: "POST",
                data: formData,
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Profile Updated',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(function () {
                        // Reload the page after SweetAlert
                        location.reload();
                    });
                },
                error: function (error) {
                    // Handle errors if needed
                    console.log(error);
                }
            });
        }
    });
});


$(document).ready(function () {
    // Show/hide password
    $('.show-password').on('click', function () {
        var inputId = $(this).data('input-id');
        var input = $('#' + inputId);

        input.attr('type', input.attr('type') === 'password' ? 'text' : 'password');
        $(this).find('i').toggleClass('fa-eye fa-eye-slash');
    });

    // Form validation
    $('#passwordResetForm').validate({
        rules: {
            current_password: 'required',
            new_password: {
                required: true,
                minlength: 8
            },
            confirm_password: {
                required: true,
                equalTo: "#new_password"
            }
        },
        messages: {
            current_password: "Please enter your current password",
            new_password: {
                required: "Please enter a new password",
                minlength: "Password must be at least 8 characters long"
            },
            confirm_password: {
                required: "Please confirm your new password",
                equalTo: "Passwords do not match"
            }
        },
        errorPlacement: function (error, element) {
            // Customize the placement of validation messages
            error.insertAfter(element.closest('.input-group'));
        },
        submitHandler: function (form) {
            // Show a confirmation dialog before submitting the form
            Swal.fire({
                title: 'Confirmation',
                text: 'Are you sure you want to reset your password?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, reset it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If the user confirms, proceed with form submission
                    var formData = $(form).serialize();

                    $.ajax({
                        url: "{{ route('reset.password') }}",
                        type: 'POST',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            Swal.fire({
                                title: response.status === 'success' ? 'Success!' : 'Error!',
                                text: response.message,
                                icon: response.status === 'success' ? 'success' : 'error',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(function () {
                                if (response.status === 'success') {
                                    // Optionally reload the page or perform other actions
                                    location.reload();
                                }
                            });
                        },
                        error: function (error) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Failed to reset password. Please try again.',
                                icon: 'error',
                                showConfirmButton: true
                            });
                        }
                    });
                }
            });
        }
    });
});


</script>

@endpush