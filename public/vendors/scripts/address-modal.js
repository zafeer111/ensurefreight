$(document).ready(function () {

    // Variable to store addressType
    var currentAddressType;

    // function empty form
    function emptyForm(){
             $('#country_id').val('');
             $('#state_id').val('');
             $('#city_id').val('');
             $('#postal_code').val('');
             $('#address').val('');
             $('#contact_person_name').val('');
             $('#contact_person_email').val('');
             $('#contact_person_no').val('');
    }

    // Function to show the loader
    function showLoader() {
        $('body').append('<div class="loader-overlay"><div class="spinner-border text-primary" role="status"></div></div>');
    }

    // Function to hide the loader
    function hideLoader() {
        $('.loader-overlay').remove();
    }

    // Bind click event only once
    $(document).off('click', '.enter-address').on('click', '.enter-address', function () {
        currentAddressType = $(this).data('address-type');
        var modalLabel = 'Enter New <span style="color: red;">' + currentAddressType.charAt(0).toUpperCase() + currentAddressType.slice(1) + '</span> Address';

        // Set the modal label HTML
        $('#addressModalLabel').html(modalLabel);

        // Show the modal
        $('#addressModal').modal('show');


        // Initialize form validation
        $('#addressForm').validate({
            rules: {
                country_id: 'required',
                state_id: 'required',
                city_id: 'required',
                postal_code: 'required',
                address: 'required',
                // contact_person_name: 'required',
            },
            messages: {
                country_id: 'Please select a country.',
                state_id: 'Please select a state.',
                city_id: 'Please select a city.',
                postal_code: 'Postal code is required.',
                address: 'Address is required.',
                // contact_person_name: 'Full name is required.',
            }
        });

        // Handle form submission
        $('#saveAddressBtn').off('click').on('click', function () {
            // Check if the form is valid
            if ($('#addressForm').valid()) {

                // Handle success, e.g., close the modal
                $('#addressModal').modal('hide');

                // Show loader
                showLoader();

                // Gather form data
                var formData = {
                    country_id: $('#country_id').val(),
                    state_id: $('#state_id').val(),
                    city_id: $('#city_id').val(),
                    postal_code: $('#postal_code').val(),
                    address: $('#address').val(),
                    contact_name: $('#contact_person_name').val(),
                    contact_email: $('#contact_person_email').val(),
                    phone_number: $('#contact_person_no').val(),
                };
                const actionUrl  = $('#addressForm').attr('action')
                // Send AJAX request
                $.ajax({
                    url: actionUrl,
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function (response) {

                        // Hide loader

                        // Check if the server response contains the expected properties
                        if (response && response.address && response.message) {
                            // Extract the nested address details
                            var addressDetails = response.address;
                            $(".select-menu").each(function () {
                                const optionMenu = this;
                                const addressCount = optionMenu.querySelector('.addresses-counter');
                                if (addressCount && typeof addressCount !== 'undefined'){
                                    let count = parseInt(addressCount.innerText) + 1;
                                    addressCount.innerText = `${count}`;
                                }
                                const type = optionMenu.getAttribute('data-type');
                                const selectBtn = optionMenu.querySelector(".select-btn");
                                const sBtn_text = optionMenu.querySelector(".sBtn-text");
                                const addressField = optionMenu.querySelector('input[name="' + type + '_id"]');
                                const options = optionMenu.querySelectorAll(".options");
                                const liText =  `${addressDetails.contact_name ?? ''}</br>
                                ${(addressDetails.contact_email || addressDetails.phone_number) ? `${addressDetails.contact_email ?? ''} ${addressDetails.phone_number ?? ''}</br>` : ''}
                                    ${addressDetails.address}, ${addressDetails.postal_code}</br>
                                    ${addressDetails?.country?.name}, ${addressDetails?.state?.name}, ${addressDetails?.city?.name}`;
                                const newLi = $(`<li class="option" data-value="${addressDetails.id}">
                                        <span class="option-text">
                                           ${liText}
                                        </span>
                                    </li>`);
                                newLi.on('click', function() {
                                    let selectedValue = addressDetails.id;
                                    selectBtn.setAttribute("data-value", selectedValue);
                                    sBtn_text.setAttribute("data-value", selectedValue);
                                    addressField.value = selectedValue;
                                    sBtn_text.innerHTML = liText;
                                    optionMenu.classList.remove("active");
                                });

                                $(options).each(function () {
                                    $(this).prepend(newLi);
                                });

                                // trigger action
                                if (currentAddressType === type ){
                                    newLi.trigger('click');
                                }
                            })
                            Notify(`${currentAddressType} address added successfully`)
                            emptyForm();
                            hideLoader();
                        } else {
                            hideLoader();
                            Notify('Something Went Wrong, Please try later','error')
                            console.error('Invalid server response:', response);
                        }

                    },
                    error: function (error) {
                        // Hide loader
                        hideLoader();
                        Notify('Something Went Wrong, Please try later','error')
                        // Handle error, e.g., display error message
                        console.error('Error:', error);
                    },
                });
            }
        });
    });

});