

    $(document).ready(function () {   
         
    $(".select-menu").each(function () {
        const optionMenu = this;
        const type = optionMenu.getAttribute('data-type');
        const selectBtn = optionMenu.querySelector(".select-btn");
        const options = optionMenu.querySelectorAll(".options .option");
        const sBtn_text = optionMenu.querySelector(".sBtn-text");
        const addressField = optionMenu.querySelector('input[name="' + type + '_id"]');
        selectBtn.addEventListener("click", () => optionMenu.classList.toggle("active"));

        options.forEach(option => {
            option.addEventListener("click", () => {
                let selectedValue = option.getAttribute("data-value");
                selectBtn.setAttribute("data-value", selectedValue);
                sBtn_text.setAttribute("data-value", selectedValue);
                addressField.value = selectedValue;
                sBtn_text.innerText = option.querySelector(".option-text").innerText;
                optionMenu.classList.remove("active");

            });
        });
    });
    
    $(document).on("click", '.select-menu[data-type="pickup"] .options .option', function () {
        updatePickupOnShipmentChange();
    });

    // Change event for "same_as_shipment" checkbox
    $('#same_as_pickup').change(function () {
        if ($(this).is(':checked')) {
            updatePickupOnShipmentChange();
        } else {
            clearAddress('shipper');
        }
    });

    // Function to update pickup information based on shipment
    function updatePickupOnShipmentChange() {
        if ($('#same_as_pickup').is(':checked')) {
            let shipmentHtml = $('.select-menu[data-type="pickup"] .sBtn-text').html();
            $('.select-menu[data-type="shipper"] .sBtn-text').html(shipmentHtml);
            $('.select-menu[data-type="shipper"] .select-btn').attr("data-value", $('input[name="pickup_id"]').val());
            $('input[name="shipper_id"]').val($('input[name="pickup_id"]').val());
        }
    }

    // Function to clear address for a given type
    function clearAddress(type) {
        let selectMenu = $('.select-menu[data-type="' + type + '"]');
        selectMenu.find('.select-btn').attr("data-value", "");
        selectMenu.find('.sBtn-text').attr("data-value", "");
        selectMenu.find('.options li').attr("data-value", "");
        selectMenu.find('.sBtn-text').text('Select your ' + type + ' options');
        $('input[name="' + type + '_id"]').val("");
    }

});