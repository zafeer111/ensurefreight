var step5Content = $(".tab-wizard section[data-skippable=true]").eq(1).clone();
var step5Removed = false;

// Define a function to generate Step 5 content
function generateStep5Content() {
    // Customize this as per your requirement to generate Step 5 content
    var content = `
        <!-- Step 5 -->
<h5 data-skippable="true">Broker Information</h5>
<section>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="broker_company_name">Broker Company Name</label>
                <input type="text" name="broker_company_name"
                       placeholder="Company Name (Optional)"
                       id="broker_company_name"
                       class="form-control">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="contact_name">Contact Name</label>
                <input type="text" name="contact_name" id="contact_name"
                       placeholder="Contact Name (Optional)"
                       class="form-control">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="phone">Phone No</label>
                <input type="text" name="phone" id="phone" placeholder="Phone No (Optional)"
                       class="form-control">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="text" name="email" id="email"
                       placeholder="Email Address (Optional)"
                       class="form-control">
            </div>
        </div>

    </div>
</section>

    `;
    return content;
}

// Define a function to handle Step 5 visibility
function handleStep5Visibility() {
    if (countryIso2 !== "CA" && !step5Removed) {
        $(".tab-wizard").steps("remove", 4);
        step5Removed = true;
    } else if (countryIso2 === "CA" && step5Removed) {
        // Generate Step 5 content
        var step5Content = generateStep5Content();
        $(".tab-wizard").steps("insert", 4, { title: "Broker Information", content: step5Content });
        step5Removed = false;
    }
}

$(".tab-wizard").steps({
    headerTag: "h5",
    bodyTag: "section",
    transitionEffect: "fade",
    titleTemplate: '<span class="step">#index#</span> #title#',
    labels: {
        finish: "Calculate Rates"
    },
    onStepChanging: function (event, currentIndex, newIndex) {
        // Assuming Step 3 (index 2) to Step 4 (index 3) transition is where you want to handle Step 5 visibility
        if (currentIndex === 2 && newIndex === 3) {
            handleStep5Visibility(); // Check Step 5 visibility
        }

        if (newIndex < currentIndex) {
            // Allow backward navigation
            return true;
        }
        return validateSteps(currentIndex);
    },
    onStepChanged: function (event, currentIndex, priorIndex) {
        // $('.steps .current').prevAll().addClass('disabled');
    },
    onFinishing: function (event, currentIndex) {
        // Final validation
        return validateSteps(currentIndex);

    },
    onFinished: function (event, currentIndex) {
        var form = $(this);

        // Show loader before submitting the form
        showLoader();

        var formData = {
            origin: $('input[name="pickup_id"]').val(),
            dest: selectedDestinationiata,
            type: $('#cargo_type').val(),
            mode: $('#mode').val(),
            dest_postal_code: document.querySelector('input[name="dest_postal_code"]').value,
            date: $('#pickup_date').val(),
            measurements: [],
            Inside_Pickup: $('[name="Inside_Pickup"]').prop('checked') ? 'Y' : 'N',
            Residential_Pickup: $('[name="Residential_Pickup"]').prop('checked') ? 'Y' : 'N',
            Do_Not_Stack: $('[name="Do_Not_Stack"]').prop('checked') ? 'Y' : 'N',
            Lifgate_Pickup: $('#liftgateCheckbox').prop('checked') ? 'Y' : 'N',
            Lifgate_Delivery: $('#liftgateCheckbox').prop('checked') ? 'Y' : 'N',
        };

        // Variable to store the total chargeable weight
        var totalChargeableWeight = 0;

        // Iterate over measurement rows
        $('.order-list tbody tr').each(function () {
            var $row = $(this);

            // Check if the row is not marked for deletion
            if (!$row.hasClass('marked-for-deletion')) {
                var volumeWeight = parseFloat($row.find('.volume-weight').data('kg-value')) || 0;
                var grossWeight = parseFloat($row.find('.gross-weight').data('kg-value')) || 0;

                var measurementData = {
                    quantity: $row.find('[name$="[quantity]"]').val(),
                    height: $row.find('[name$="[height]"]').val(),
                    width: $row.find('[name$="[width]"]').val(),
                    length: $row.find('[name$="[length]"]').val(),
                    dimension_unit: $row.find('[name$="[dimension_unit]"]').val(),
                    chargeable_weight: Math.max(volumeWeight, grossWeight),
                };
                // Calculate chargeable weight for the row
                var chargeableWeight = Math.max(volumeWeight, grossWeight);
                totalChargeableWeight += Math.round(chargeableWeight);

                formData.measurements.push(measurementData);
            }
        });

        // Convert dimensions to inches
        formData.measurements.forEach(function (measurementData) {
            measurementData.height = convertToInches(measurementData.height, measurementData.dimension_unit);
            measurementData.width = convertToInches(measurementData.width, measurementData.dimension_unit);
            measurementData.length = convertToInches(measurementData.length, measurementData.dimension_unit);
        });

        formData.weight = totalChargeableWeight.toFixed(2);
        // Use AJAX to submit the form
        performAjaxRequest(formData);
    },
});


function convertToInches(value, unit) {
    var inches;
    if (unit === '2') {
        inches = value * 0.393701; // 1 cm = 0.393701 inches
    } else if (unit === '3') {
        inches = value * 39.3701; // 1 m = 39.3701 inches
    } else {
        inches = value; // No conversion needed for inches
    }

    // Format to two decimal places if not inches
    if (unit !== '1') {
        inches = inches.toFixed(2);
    }

    return inches;
}
// Bind the click event for the "Try Again" button
$(document).on('click', '#tryAgainBtn', function () {
    // Close the existing modal
    $('#success-modal').modal('hide');

    // Show loader before making the AJAX request
    showLoader();

    // Get the form data
    var formData = getFormData();

    // Use AJAX to submit the form
    performAjaxRequest(formData);
});

function modalHeader(originCode = null, destCode = null, totalCount = null, weight = null, type, exception = '') {

    var modalContentHeader = '<div class="row">';

    modalContentHeader += '<div class="col-md-3 modal-content-left">';
    if (originCode && destCode)
        modalContentHeader += '<span id="referenceNoSpan" style="margin-top: 10px;"> </span>';

    modalContentHeader += '</div>';

    modalContentHeader += '<div class="col-md-6 modal-content-center">';
    if (totalCount && type) {
        modalContentHeader += '<h3 class="mb-120">' + totalCount + ' Rates Available for <span style="color: red;">' + type + '</span></h3>';
    } else {
        modalContentHeader += '<h3 class="mb-120">' + exception + '<span style="color: red;">' + type + '</span></h3>';
    }

    if (weight)
        modalContentHeader += '<p>Rates calculated for ' + Math.round(weight) + ' kg</p>';

    modalContentHeader += '</div>';

    modalContentHeader += '<div class="col-md-3 modal-content-right">';
    modalContentHeader += '<img src="' + baseUrl + '/images/logo1.png" alt="Logo" style="max-height: 120px;max-width: 120px;margin-left: 60px;margin-top: 5px;">';
    modalContentHeader += '</div>';

    modalContentHeader += '</div>';
    return modalContentHeader;
}

// function modalFooter(errorModal = false) {
//     var modalContentFooter = '<div class="modal-footer d-flex justify-content-between align-items-center">';

//     // Add a div to center the terms and conditions
//     modalContentFooter += '<div class="form-check text-center flex-grow-1">';
//     if (errorModal) {

//     }else{
//         modalContentFooter += '<input type="checkbox" class="form-check-input" style="margin-top: 0.5rem;" id="acceptTerms">';
//         modalContentFooter += '<label class="form-check-label" for="acceptTerms">I accept the <a href="/terms" target="_blank">Terms & Conditions</a></label>';
//     //TODO: Add footer for exception
//     }
//     modalContentFooter += '</div>';
//     // Close the modal footer
//     modalContentFooter += '</div>';
//     return modalContentFooter
// }
function modalFooter(errorModal = false) {
    var modalContentFooter = '<div class="row">';

    modalContentFooter += '<div class="col-md-3"></div>';

    modalContentFooter += '<div class="col-md-6">';
    if (errorModal) {
        // Handle error modal content here if needed
    } else {
        modalContentFooter += '<div class="form-check text-center">';
        modalContentFooter += '<input type="checkbox" class="form-check-input" style="margin-top: 0.5rem;" id="acceptTerms">';
        modalContentFooter += '<label class="form-check-label" for="acceptTerms">I accept the <a href="/terms" target="_blank">Terms & Conditions</a></label>';
        modalContentFooter += '</div>';
    }
    modalContentFooter += '</div>';

    modalContentFooter += '<div class="col-md-3 text-center">'
    modalContentFooter += '<button id="downloadButton" class="btn btn-primary btn-sm">Download</button>';
    modalContentFooter += '</div>';

    modalContentFooter += '</div>';

    return modalContentFooter;
}

function removeTrailingSlash(str) {
    return str.replace(/\/+$/, '');
}

// Function to handle AJAX request and response
function performAjaxRequest(formData) {

    $.ajax({
        url: "/api/get-airline-tariff",
        method: 'POST',
        data: formData,
        success: function (response) {
            // Hide loader after form submission
            hideLoader();
            response.sort(function (a, b) {
                return a.rate_per_kg - b.rate_per_kg;
            });

            // Find the carrier with the minimum rate_per_kg
            var minRateCarrier = response.reduce(function (min, carrier) {
                return min.rate_per_kg < carrier.rate_per_kg ? min : carrier;
            }, response[0]);

            var totalCount = response.length;
            var type = response[0]?.type || ' - ';
            var weight = formData.weight;
            var originCode = response[0].origin;
            var destCode = response[0].dest;

            // Function to handle click events on Confirm and Negotiate buttons
            $(document).on('click', '.confirm-btn, .negotiate-btn', function () {
                var index = $(this).data('index');

                // Remove the focused-row class from all rows
                $('[id^="carrier-row-"]').removeClass('focused-row');

                // Add the focused-row class to the clicked row
                $('#carrier-row-' + index).addClass('focused-row');
            });

            // Document click event handler to remove the focused-row class when clicking elsewhere
            $(document).on('click', function (event) {
                // Check if the clicked element is not a Confirm or Negotiate button
                if (!$(event.target).closest('.confirm-btn, .negotiate-btn').length) {
                    // Remove the focused-row class from all rows
                    $('[id^="carrier-row-"]').removeClass('focused-row');
                }
            });

            var inquiryData = prepareInquiryData(response);
            inquirySubmission(inquiryData);

            // Function to inquiry Data
            function prepareInquiryData(response) {
                var Data = {
                    mode: $('#mode').val(),
                    priority: $('#priority').val(),
                    commodity: $('#commodity').val(),
                    origin: $('input[name="pickup_id"]').val(),
                    shipment: $('input[name="shipper_id"]').val(),
                    dest: selectedDestinationiata,
                    type: $('#cargo_type').val(),
                    dest_postal_code: document.querySelector('input[name="dest_postal_code"]').value,
                    date: $('#pickup_date').val(),
                    incoterms: $('#incoterms').val(),
                    user_reference_number: $('#user_reference_number').val(),
                    pickup_reference: $('#pickup_reference').val(),
                    notes: $('#notes').val(),
                    status: 3,

                    //broker
                    broker_company_name: $('#broker_company_name').val(),
                    contact_name: $('#contact_name').val(),
                    phone: $('#phone').val(),
                    email: $('#email').val(),

                    //measurements
                    measurements: [],

                    // Checkbox values as integers
                    inside_pickup: $('input[name="Inside_Pickup"]').is(':checked') ? 1 : 0,
                    residential_pickup: $('input[name="Residential_Pickup"]').is(':checked') ? 1 : 0,
                    liftgate_required: $('input[name="Liftgate_Required"]').is(':checked') ? 1 : 0,
                    do_not_stack: $('input[name="Do_Not_Stack"]').is(':checked') ? 1 : 0,
                };

                // Iterate over measurement rows
                $('.order-list tbody tr').each(function () {
                    var $row = $(this);

                    // Check if the row is not marked for deletion
                    if (!$row.hasClass('marked-for-deletion')) {
                        var volumeWeight = parseFloat($row.find('.volume-weight').data('kg-value')) || 0;
                        var grossWeight = parseFloat($row.find('.gross-weight').data('kg-value')) || 0;

                        var measurementData = {
                            quantity: $row.find('[name$="[quantity]"]').val(),
                            height: $row.find('[name$="[height]"]').val(),
                            width: $row.find('[name$="[width]"]').val(),
                            length: $row.find('[name$="[length]"]').val(),
                            dimension_unit: $row.find('[name$="[dimension_unit]"]').val(),
                            weight_unit: $row.find('[name$="[weight_unit]"]').val(),
                            weight: Math.max(volumeWeight, grossWeight).toFixed(2),
                        };

                        // Convert dimensions to inches
                        measurementData.height = convertToInches(measurementData.height, measurementData.dimension_unit);
                        measurementData.width = convertToInches(measurementData.width, measurementData.dimension_unit);
                        measurementData.length = convertToInches(measurementData.length, measurementData.dimension_unit);

                        // Update dimension_unit to reflect inches
                        measurementData.dimension_unit = '1'; // '1' represents inches

                        // Update weight_unit to reflect kg
                        measurementData.weight_unit = '2'; // '2' represents kilograms

                        Data.measurements.push(measurementData);
                    }
                });

                return Data;
            }

            var quotationData = prepareQuotationData(response);
            // Function to quotation Data
            function prepareQuotationData(response) {
                var quotationData = {
                    // quotation
                    from: originCode,
                    to: destCode,
                    weight: weight,
                    pickup_carrier_name: response[0].pickup_carrier_name,
                    profit: response[0].profit !== null ? response[0].profit : null,
                    pickup_charge: response[0].pickup_charge !== null ? response[0].pickup_charge : null,
                    bonded_charge: response[0].carrier_bonded_charges !== null ? response[0].carrier_bonded_charges : null,
                    cargo_type: response[0].cargo_type,
                    quotation_status: 0,

                    // Array to store carrier data
                    carriers: [],
                };

                // Add carrier data from the response
                response.forEach(function (carrier, index) {
                    // Here, we add quotation_line_items_status with a default value of 0
                    var carrierData = {
                        carrier_id: carrier.carrier_id,
                        tariff_rate: carrier.carrier_tariff_rate,
                        surcharge: carrier.carrier_surcharge,
                        airable_charge: carrier.carrier_airable_fee,
                        custom_charge: carrier.carrier_custom_charges,
                        rate_per_kg: carrier.rate_per_kg,
                        zero_profit_rate: carrier.zero_profit_rate,
                        total_rate: carrier.total_rate,
                        quotation_line_items_status: 0,
                    };
                    quotationData.carriers.push(carrierData);
                });
                return quotationData;
            }

            // Inquiry submission when user click the calculate rates
            function inquirySubmission(inquiryData) {
                $.ajax({
                    url: '/inquiries/store',
                    method: 'POST',
                    data: inquiryData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        var inquiryId = response.inquiry.id;
                        var referenceId = response.referenceNoId;
                        var referenceNo = response.referenceNo;
                        $.notify(`Inquiry created successfully. Ref No: ${referenceNo}`, "success");
                        $('#referenceNoSpan').text('Quote ID: ' + referenceNo);

                        quotationSubmission(quotationData, inquiryId, referenceId);
                        quotePDF(inquiryId)

                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }

            // Function to send data to create a quotation
            function quotationSubmission(quotationData, inquiryId, referenceNo) {
                quotationData.inquiry_id = inquiryId;
                quotationData.reference_no_id = referenceNo;
                $.ajax({
                    url: '/quotations/store',
                    method: 'POST',
                    data: quotationData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        $(document).on("click", ".confirm-btn", function () {
                            if ($('#acceptTerms').is(':checked')) {
                                var index = $(this).data('index');

                                var quotationId = response.id;
                                var quotationLineItemId = response.quotation_line_items[index].id;

                                updateStatus(quotationId, quotationLineItemId, 1);

                                var bookingData = generateBookingData(response, index);
                                sendBookingDataToController(bookingData);

                            } else {
                                $.notify("Please accept the terms and conditions.");
                            }
                        });

                        // Function to generate booking data
                        function generateBookingData(response, index) {
                            return {
                                quotation_id: response.id,
                                status: 0,
                                carrier_id: response.quotation_line_items[index].carrier_id,
                                tariff_rate: response.quotation_line_items[index].tariff_rate,
                                surcharge: response.quotation_line_items[index].surcharge,
                                airable_charge: response.quotation_line_items[index].airable_charge,
                                custom_charge: response.quotation_line_items[index].custom_charge,
                                rate_per_kg: response.quotation_line_items[index].rate_per_kg,
                                total_rate: response.quotation_line_items[index].total_rate,
                                reference_no_id: referenceNo,
                            };
                        }

                        // Event handler for the Negotiate button click
                        $(document).on("click", ".negotiate-btn", function () {
                            if ($('#acceptTerms').is(':checked')) {
                                var index = $(this).data('index');

                                console.log('negotiate button ' + index)
                            } else {
                                $.notify("Please accept the terms and conditions.");
                            }
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }

            function updateStatus(quotationId, quotationLineItemId, status) {
                var statusData = {
                    quotation_id: quotationId,
                    quotation_line_item_id: quotationLineItemId,
                    status: status
                }
                $.ajax({
                    url: '/quotations/' + quotationId + '/lineitems/' + quotationLineItemId + '/' + status,
                    method: 'PUT',
                    data: statusData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            function sendBookingDataToController(bookingData) {
                $.ajax({
                    url: '/bookings/store',
                    method: 'POST',
                    data: bookingData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        swal({
                            icon: 'success',
                            text: 'Complete your Booking',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(function () {
                            setTimeout(function () {
                                window.location.href = '/bookings/create/' + response.booking_id;
                            }, 2000);
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                        swal("Error!", "An error occurred. Please try again.", "error");
                    }
                });
            }


            // Initialize the modal content within a div
            let modalContent = modalHeader(originCode, destCode, totalCount, weight, type)

            // Initialize the table
            modalContent += '<table class="table">';
            modalContent += '<thead>';
            modalContent += '<tr>';
            modalContent += '<th scope="col">Carriers</th>';
            modalContent += '<th scope="col">Route</th>';
            modalContent += '<th scope="col">Transit Time (Days)</th>';
            modalContent += '<th scope="col">Rates (USD)</th>';
            modalContent += '<th scope="col">Acceptance</th>';
            modalContent += '</tr>';
            modalContent += '</thead>';
            modalContent += '<tbody>';

            // Iterate over the response and add rows to the table
            response.forEach(function (carrier, index) {
                modalContent += '<tr id="carrier-row-' + index + '">';

                // Apply bold font to the row with the least price carrier
                var isMinRateCarrier = carrier === minRateCarrier;

                modalContent += '<td style="font-weight: ' + (isMinRateCarrier ? 'bold' : 'normal') + ';">';
                modalContent += '<img src="' + removeTrailingSlash(carrier.logo) + '" alt="Carrier Logo" style="max-height: 35px; max-width: 35px; margin-right: 10px;">';
                modalContent += '<p>' + carrier.carrier_name + " (" + carrier.carrier_code + ")" + '</p>';

                // Add Recommended badge for the carrier with the minimum rate_per_kg
                if (isMinRateCarrier) {
                    modalContent += '<span class="badge badge-pill badge-success">Recommended</span>';
                }

                modalContent += '</td>';

                var day = carrier.day !== null ? carrier.day : '-';
                modalContent += '<td style="font-weight: ' + (isMinRateCarrier ? 'bold' : 'normal') + ';">';
                modalContent += '<p style="margin-bottom: 4px;">' + originCode + '-' + destCode + '</p>';
                modalContent += '<p>' + " " + '</p>';
                modalContent += '</td>';

                modalContent += '<td style="font-weight: ' + (isMinRateCarrier ? 'bold' : 'normal') + ';"> 4-5 </td>';
                modalContent += '<td style="font-weight: ' + (isMinRateCarrier ? 'bold' : 'normal') + ';">' + carrier.rate_per_kg + " /kg" + '</td>';
                modalContent += '<td>';
                modalContent += '<button type="button" class="btn btn-primary btn-sm confirm-btn" data-index="' + index + '" disabled data-toggle="tooltip" data-placement="top" title="Coming soon">Accept</button>';
                modalContent += '<button type="button" class="btn btn-success btn-sm negotiate-btn ml-2" data-index="' + index + '" disabled data-toggle="tooltip" data-placement="top" title="Coming soon">Negotiate</button>'; // Negotiate button
                modalContent += '</td>';
                modalContent += '</tr>';

            });

            // Close the table
            modalContent += '</tbody>';
            modalContent += '</table>';

            // Assuming your existing modal footer code

            modalContent += modalFooter();


            // Update the success modal content with the formatted API response
            $('#success-modal .modal-body').html(modalContent);
            // Show success modal
            $('#success-modal').modal('show');

            // Initialize Bootstrap tooltips
            $('[data-toggle="tooltip"]').tooltip();

            function quotePDF(inquiryId){
                $(document).ready(function() {
                    $('#downloadButton').on('click', function() {
                        var downloadUrl = '/download-quote';
            
                        $.ajax({
                            url: downloadUrl,
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                inquiry_id: inquiryId
                            },
                            success: function(response) {
                                console.log(response.message);
                            },
                            error: function(xhr, status, error) {
                                console.error(error);
                            }
                        });
                    });
                });
            }

        },
        error: function (xhr, status, error) {
            // Hide loader if there's an error
            hideLoader();

            // Display the specific error message thrown in the API
            var errorMessage = "An error occurred. Please try again.";

            if (xhr.status === 404 || xhr.status === 500 || xhr.status === 422) {
                errorMessage = xhr.responseJSON.message
            }

            // if (xhr.responseJSON && xhr.responseJSON.error) {
            //     errorMessage = xhr.responseJSON.error;
            // }
            const cargoTypeText = $('#cargo_type option:selected').text()
            let modalError = modalHeader(null, null, null, null, cargoTypeText, 'Exceptions For ')

            modalError += '<ul><li style="color: red;">' + errorMessage + '</li></ul>'

            modalError += '<div class="modal-footer d-flex justify-content-between align-items-center">';
            modalError += '<p>' + 'Submit your query manually' + '</p>';
            modalError += '<br>';
            modalError += '<button type="button" class="btn btn-danger exception-btn">Submit</button>';
            modalError += '</div>';
            // modalError += modalFooter()
            // Update the success modal content with the error message
            $('#success-modal .modal-body').html(modalError);

            // Show success modal
            $('#success-modal').modal('show');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            //exception_inquiries ajax request
            $('.exception-btn').click(function (event) {
                event.preventDefault();

                // Serialize form data
                var formData = {
                    mode: $('#mode').val(),
                    priority: $('#priority').val(),
                    commodity: $('#commodity').val(),
                    origin: $('input[name="pickup_id"]').val(),
                    shipment: $('input[name="shipper_id"]').val(),
                    dest: selectedDestinationiata,
                    type: $('#cargo_type').val(),
                    dest_postal_code: document.querySelector('input[name="dest_postal_code"]').value,
                    date: $('#pickup_date').val(),
                    incoterms: $('#incoterms').val(),
                    user_reference_number: $('#user_reference_number').val(),
                    pickup_reference: $('#pickup_reference').val(),
                    notes: $('#notes').val(),
                    status: 5,

                    //exception
                    exception_message: errorMessage,

                    //broker
                    broker_company_name: $('#broker_company_name').val(),
                    contact_name: $('#contact_name').val(),
                    phone: $('#phone').val(),
                    email: $('#email').val(),

                    //measurements
                    measurements: [],

                    // Checkbox values as integers
                    inside_pickup: $('input[name="Inside_Pickup"]').is(':checked') ? 1 : 0,
                    residential_pickup: $('input[name="Residential_Pickup"]').is(':checked') ? 1 : 0,
                    liftgate_required: $('input[name="Liftgate_Required"]').is(':checked') ? 1 : 0,
                    do_not_stack: $('input[name="Do_Not_Stack"]').is(':checked') ? 1 : 0,
                };

                // Add from_exception field to indicate exception submission
                formData.from_exception = true;

                 // Iterate over measurement rows
                 $('.order-list tbody tr').each(function () {
                    var $row = $(this);

                    // Check if the row is not marked for deletion
                    if (!$row.hasClass('marked-for-deletion')) {
                        var volumeWeight = parseFloat($row.find('.volume-weight').data('kg-value')) || 0;
                        var grossWeight = parseFloat($row.find('.gross-weight').data('kg-value')) || 0;

                        var measurementData = {
                            quantity: $row.find('[name$="[quantity]"]').val(),
                            height: $row.find('[name$="[height]"]').val(),
                            width: $row.find('[name$="[width]"]').val(),
                            length: $row.find('[name$="[length]"]').val(),
                            dimension_unit: $row.find('[name$="[dimension_unit]"]').val(),
                            weight_unit: $row.find('[name$="[weight_unit]"]').val(),
                            weight: Math.max(volumeWeight, grossWeight).toFixed(2),
                        };

                        // Convert dimensions to inches
                        measurementData.height = convertToInches(measurementData.height, measurementData.dimension_unit);
                        measurementData.width = convertToInches(measurementData.width, measurementData.dimension_unit);
                        measurementData.length = convertToInches(measurementData.length, measurementData.dimension_unit);

                        // Update dimension_unit to reflect inches
                        measurementData.dimension_unit = '1'; // '1' represents inches

                        // Update weight_unit to reflect kg
                        measurementData.weight_unit = '2'; // '2' represents kilograms

                        formData.measurements.push(measurementData);
                    }
                });
                // Expection inquiry ajax method
                $.ajax({
                    url: '/inquiries/store',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        swal({
                            title: "Success!",
                            text: response.message,
                            icon: "success",
                            timer: 2000,
                            buttons: false,
                            showConfirmButton: false,
                        });

                        setTimeout(function () {
                            window.location.href = '/inquiries';
                        }, 2500);
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                        swal("Error!", "An error occurred. Please try again.", "error");
                    }
                });
            });

        }
    });
}

// Function to show the loader
function showLoader() {
    $('body').append('<div class="loader-overlay"><div class="spinner-border text-primary" role="status"></div></div>');
}

// Function to hide the loader
function hideLoader() {
    $('.loader-overlay').remove();
}


// Function to get form data
function getFormData() {
    var formData = {
        origin: $('input[name="pickup_id"]').val(),
        dest: selectedDestinationiata,
        type: $('#cargo_type').val(),
        mode: $('#mode').val(),
        dest_postal_code: document.querySelector('input[name="dest_postal_code"]').value,
        date: $('#pickup_date').val(),
        measurements: [],
        Inside_Pickup: $('[name="Inside_Pickup"]').prop('checked') ? 'Y' : 'N',
        Residential_Pickup: $('[name="Residential_Pickup"]').prop('checked') ? 'Y' : 'N',
        Do_Not_Stack: $('[name="Do_Not_Stack"]').prop('checked') ? 'Y' : 'N',
        Lifgate_Pickup: $('#liftgateCheckbox').prop('checked') ? 'Y' : 'N',
        Lifgate_Delivery: $('#liftgateCheckbox').prop('checked') ? 'Y' : 'N',
    };

    var totalChargeableWeight = 0;

    // Iterate over measurement rows
    $('.order-list tbody tr').each(function () {
        var $row = $(this);

        // Check if the row is not marked for deletion
        if (!$row.hasClass('marked-for-deletion')) {
            var measurementData = {
                quantity: $row.find('[name$="[quantity]"]').val(),
                height: $row.find('[name$="[height]"]').val(),
                width: $row.find('[name$="[width]"]').val(),
                length: $row.find('[name$="[length]"]').val(),
                dimension_unit: $row.find('[name$="[dimension_unit]"]').val(),
            };

            // Calculate chargeable weight for the row
            var volumeWeight = parseFloat($row.find('.volume-weight').data('kg-value')) || 0;
            var grossWeight = parseFloat($row.find('.gross-weight').data('kg-value')) || 0;
            var chargeableWeight = Math.max(volumeWeight, grossWeight);
            totalChargeableWeight += Math.round(chargeableWeight);

            formData.measurements.push(measurementData);
        }
    });

    // Convert dimensions to inches
    formData.measurements.forEach(function (measurementData) {
        measurementData.height = convertToInches(measurementData.height, measurementData.dimension_unit);
        measurementData.width = convertToInches(measurementData.width, measurementData.dimension_unit);
        measurementData.length = convertToInches(measurementData.length, measurementData.dimension_unit);
    });

    formData.weight = totalChargeableWeight.toFixed(2);

    return formData;
}


// Function to validate a single row
function validateRow(row) {
    let isValid = true;

    // Fields to validate
    const normalFields = ['quantity', 'length', 'width', 'height', 'weight'];
    const selectFields = ['dimension_unit', 'weight_unit'];

    const errorMessages = {
        quantity: 'Quantity is required',
        length: 'Length is required',
        width: 'Width is required',
        height: 'Height is required',
        weight: 'Weight is required',
        dimension_unit: 'Dimension Unit is required',
        weight_unit: 'Weight Unit is required',
    };

    // Validate normal input fields
    normalFields.forEach(function (fieldName) {
        const inputField = row.find(`input[name^='measurements'][name$='[${fieldName}]']`);
        const inputValue = inputField.val();

        if (!inputValue || isNaN(inputValue) || parseFloat(inputValue) <= 0) {
            isValid = false;
            Notify(errorMessages[fieldName], 'error');
        }
    });

    // Validate select input fields
    selectFields.forEach(function (fieldName) {
        const selectField = row.find(`select[name^='measurements'][name$='[${fieldName}]']`);
        const selectedValue = selectField.val();

        if (!selectedValue) {
            isValid = false;
            Notify(errorMessages[fieldName], 'error');
        }
    });

    return isValid;
}


function validateSteps(index) {
    let res = true;
    switch (index) {
        case 0: // origin 1
            const shipmentId = document.querySelector('input[name="shipper_id"]').value;
            const pickupId = document.querySelector('input[name="pickup_id"]').value;
            if (shipmentId.length === 0) {
                Notify('Shipper address is required', 'error')
                res = false;
            }
            if (pickupId.length === 0) {
                Notify('Pickup address is required', 'error')
                res = false;
            }

            break;
        case 1: //destination 2
            const mode = document.querySelector('select[name="mode"]').value;
            const destPostalCode = document.querySelector('input[name="dest_postal_code"]').value;
            if (mode.length === 0) {
                Notify('Mode is required', 'error');
                res = false;
            }

            if (mode === '1') {
                if (!selectedDestination) {
                    Notify('Please select destination', 'error');
                    res = false;
                }
            } else if (mode === '2') {
                if (destPostalCode.length === 0) {
                    Notify('Postal Code is required', 'error');
                    res = false;
                } else {
                    // Add your specific validation logic for destination postal code here
                    // For example, you can use regular expressions to validate the format
                    const usaPostalCodeRegex = /^\d{5}(-\d{4})?$/;
                    const canadaPostalCodeRegex = /^[A-Za-z]\d[A-Za-z] \d[A-Za-z]\d$/;
                    if (!(usaPostalCodeRegex.test(destPostalCode) || canadaPostalCodeRegex.test(destPostalCode))) {
                        Notify('Invalid Postal Code format', 'error');
                        res = false;
                    }
                }
            }
            break;
        case 2: // details 3
            const commodity = document.querySelector('input[name="commodity"]').value;
            const incoterms = document.querySelector('input[name="incoterms"]').value;
            const cargoType = document.querySelector('select[name="cargo_type"]').value;
            const pickupDate = document.querySelector('input[name="pickup_date"]').value;

            if (commodity.length === 0) {
                Notify('Item Description is required', 'error');
                res = false;
            }
            if (incoterms.length === 0) {
                Notify('Incoterms is required', 'error');
                res = false;
            }
            if (cargoType.length === 0) {
                Notify('Tariff Segment is required', 'error');
                res = false;
            }
            if (pickupDate.length === 0) {
                Notify('Pickup Date is required', 'error');
                res = false;
            }
            break;
        case 3: // skids 4
            // Validate all measurement rows
            let isValidRows = true;
            $("table.order-list tbody tr").each(function () {
                if (!validateRow($(this))) {
                    isValidRows = false;
                    return false;
                }
            });

            res = isValidRows;
            break;

        case 5: // other details
            const priority = document.querySelector('select[name="priority"]').value;

            if (priority.length === 0) {
                Notify('Priority is required', 'error');
                res = false;
            }
            break;
    }
    return res;
}