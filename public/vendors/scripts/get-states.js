
$(document).ready(function () {
    // Set initial selected values for state and city on page load
    var initialCountryId = $('#country_id').val();
    var initialStateId = $('#state_id').val();

    // Call function to set initial states and cities
    setStatesAndCities(initialCountryId, initialStateId);

    // Handle country change
    $('#country_id').change(function (event) {
        var countryId = $(this).val();

        // Clear existing states and cities
        $('#state_id').empty().append('<option value="">Select a State</option>');
        $('#city_id').empty().append('<option value="">Select a City</option>');

        if (countryId) {
            // Call function to set states and cities based on country
            setStatesAndCities(countryId, null);
        }
    });

    // Handle state change
    $('#state_id').change(function (event) {
        var stateId = $(this).val();

        // Clear existing cities
        $('#city_id').empty().append('<option value="">Select a City</option>');

        if (stateId) {
            // Call function to set cities based on state
            setCities(stateId);
        }
    });

    // Function to set states and cities based on country and state
    function setStatesAndCities(countryId, stateId) {
        $.ajax({
            url: '/get-states/' + countryId,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                // Clear existing states
                $('#state_id').empty().append('<option value="">Select a State</option>');

                // Populate states dropdown
                $.each(data, function (key, value) {
                    var selected = (stateId && stateId == value.id) ? 'selected' : '';
                    $('#state_id').append('<option value="' + value.id + '" ' + selected + '>' + value.name + '</option>');
                });

                // If stateId is provided, trigger change event to set cities
                if (stateId) {
                    $('#state_id').trigger('change');
                }
            }
        });
    }

    // Function to set cities based on state
    function setCities(stateId) {
        $.ajax({
            url: '/get-cities/' + stateId,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                // Populate city dropdown
                $.each(data, function (key, value) {
                    $('#city_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
            }
        });
    }
});