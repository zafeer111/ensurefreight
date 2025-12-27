@extends('layouts.admin')
@push('style')
        
<style>



</style>
@endpush('style')

@section('content')
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Booking</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('customer.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('bookings.index') }}">Bookings</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Create Booking
                        </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Default Basic Forms Start -->
        <div class="pd-20 card-box mb-30">
						<div class="clearfix">
							<h4 class="text-blue h4">Complete Your Booking</h4>
						</div>
						<div class="wizard-content">
							<form class="booking-wizard wizard-circle wizard">
								<h5>Bill of Lading</h5>
								<section>
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label>Customer Order No<span style="color: red">*</span></label>
											<input type="text" class="form-control" name="customer_order_no" placeholder="Enter Customer Order No" required />
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>Packages<span style="color: red">*</span></label>
											<input type="text" class="form-control" name="packages" placeholder="Enter Packages" required />
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>Quantity Number<span style="color: red">*</span></label>
											<select class="custom-select form-control" name="quantity_number" required>
												@for ($i = 1; $i <= 100; $i++)
													<option value="{{ $i }}">{{ $i }}</option>
												@endfor
											</select>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label>Type<span style="color: red">*</span></label>
											<select class="custom-select form-control" name="select_type" required>
												<option value="skids">Skids</option>
												<option value="cube">Cube</option>
												<option value="slice">Slice</option>
											</select>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>NMFC No<span style="color: red">*</span></label>
											<input type="text" class="form-control" name="nmfc_no" placeholder="Enter NMFC No" required />
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>Class<span style="color: red">*</span></label>
											<input type="text" class="form-control" name="class" placeholder="Enter Class" required />
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label>Select Currency<span style="color: red">*</span></label>
											<select class="custom-select form-control" name="currency" required>
												<option value="usd">USD</option>
												<option value="cad">CAD</option>
											</select>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>Input Amount<span style="color: red">*</span></label>
											<input type="text" class="form-control" name="amount" placeholder="Enter Amount" required />
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>FOB<span style="color: red">*</span></label>
											<select class="custom-select form-control" name="fob" required>
												<option value="warehouse">Warehouse</option>
												<option value="ex_works">Ex Works</option>
											</select>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label>Trailer Loaded:</label><br>
											<input type="checkbox" name="trailer_loaded_shipper" checked> By Shipper<br>
											<input type="checkbox" name="trailer_loaded_driver"> By Driver
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>Freight Counted:</label><br>
											<input type="checkbox" name="freight_counted_shipper" checked> By Shipper<br>
											<input type="checkbox" name="freight_counted_driver_pallets" checked> By Driver/pallets said to contain<br>
											<input type="checkbox" name="freight_counted_driver_pieces"> By Driver/Pieces
										</div>
									</div>
									<div class="col-md-4">
										<!-- This column is intentionally left empty to maintain the structure -->
									</div>
								</div>

								<br>
								<!-- Add a button for generating PDF -->
								<button id="generatePDFButton" type="button" class="btn btn-primary">Generate PDF</button>

								</section>
								<!-- Step 2 -->
								<h5>Air Waybill</h5>
								<section>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>Job Title :</label>
												<input type="text" class="form-control" />
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Company Name :</label>
												<input type="text" class="form-control" />
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label>Job Description :</label>
												<textarea class="form-control"></textarea>
											</div>
										</div>
									</div>
								</section>
								<!-- Step 3 -->
								<h5>Label</h5>
								<section>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>Interview For :</label>
												<input type="text" class="form-control" />
											</div>
											<div class="form-group">
												<label>Interview Type :</label>
												<select class="form-control">
													<option>Normal</option>
													<option>Difficult</option>
													<option>Hard</option>
												</select>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Interview Date :</label>
												<input
													type="text"
													class="form-control date-picker"
													placeholder="Select Date"
												/>
											</div>
											<div class="form-group">
												<label>Interview Time :</label>
												<input
													class="form-control time-picker"
													placeholder="Select time"
													type="text"
												/>
											</div>
										</div>
									</div>
								</section>
								<!-- Step 4 -->
								<h5>Security Letter</h5>
								<section>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>Behaviour :</label>
												<input type="text" class="form-control" />
											</div>
											<div class="form-group">
												<label>Confidance</label>
												<input type="text" class="form-control" />
											</div>
											<div class="form-group">
												<label>Result</label>
												<select class="form-control">
													<option>Select Result</option>
													<option>Selected</option>
													<option>Rejected</option>
												</select>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Comments</label>
												<textarea class="form-control"></textarea>
											</div>
										</div>
									</div>
								</section>
							</form>
						</div>
					</div>


        
    </div>

@endsection

@push('script')

<script src="{{ asset('src/plugins/jquery-steps/jquery.steps.js') }}"></script>
<script src="{{ asset('vendors/scripts/steps-setting.js') }}"></script>

<script>


	    // Function to check if all fields in step 1 are filled
		function validateStep1() {
        var isValid = true;
        
        // Check Customer Order No
        if (!$('input[name="customer_order_no"]').val()) {
            isValid = false;
        }
        
        // Check Packages
        if (!$('input[name="packages"]').val()) {
            isValid = false;
        }
        
        // Check Quantity Number
        if (!$('select[name="quantity_number"]').val()) {
            isValid = false;
        }
        
        // Check Type
        if (!$('select[name="select_type"]').val()) {
            isValid = false;
        }
        
        // Check NMFC No
        if (!$('input[name="nmfc_no"]').val()) {
            isValid = false;
        }
        
        // Check Class
        if (!$('input[name="class"]').val()) {
            isValid = false;
        }
        
        // Check Currency
        if (!$('select[name="currency"]').val()) {
            isValid = false;
        }
        
        // Check Amount
        if (!$('input[name="amount"]').val()) {
            isValid = false;
        }
        
        // Check FOB
        if (!$('select[name="fob"]').val()) {
            isValid = false;
        }

        return isValid;
    }


$(document).ready(function() {
    // Bind click event to "Generate BOL" button
    $("#generatePDFButton").on("click", function() {

		var booking = {!! json_encode($booking) !!};

        var formData = {
            booking_id: booking.id,
			customer_order_no: $('input[name="customer_order_no"]').val(),
            packages: $('input[name="packages"]').val(),
            quantity_number: $('select[name="quantity_number"]').val(),
            select_type: $('select[name="select_type"]').val(),
            nmfc_no: $('input[name="nmfc_no"]').val(),
            class: $('input[name="class"]').val(),
            currency: $('select[name="currency"]').val(),
            amount: $('input[name="amount"]').val(),
            fob: $('select[name="fob"]').val(),
			trailer_loaded_shipper: $('input[name="trailer_loaded_shipper"]').is(":checked") ? 1 : 0,
			trailer_loaded_driver: $('input[name="trailer_loaded_driver"]').is(":checked") ? 1 : 0,
			freight_counted_shipper: $('input[name="freight_counted_shipper"]').is(":checked") ? 1 : 0,
			freight_counted_driver_pallets: $('input[name="freight_counted_driver_pallets"]').is(":checked") ? 1 : 0,
			freight_counted_driver_pieces: $('input[name="freight_counted_driver_pieces"]').is(":checked") ? 1 : 0,

        };

        if (validateStep1()) {

        // Send data to the server using AJAX
        $.ajax({
            url: "/generate-bol-pdf", 
            method: "POST",
            data: formData,
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
            success: function(response) {
                // Handle success response
                console.log("PDF generated successfully:", response);
				$.notify("BOL PDF generated successfully", "success");
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error("Error occurred while generating PDF:", error);
            }
        });

		} else {
				// If any field is empty, show error notification
				$.notify("Please fill in all required fields", "error");
			}
    });
});
</script>

@endpush