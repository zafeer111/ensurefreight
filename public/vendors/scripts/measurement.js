$(document).ready(function () {
    // Initialize the counter based on the maximum index of existing measurements
    var counter = Math.max(...$("[name^='measurements']").map(function () {
        return parseInt($(this).attr('name').match(/\d+/)) || 0;
    }).get()) + 1;

    
    // $("table.order-list tbody tr .addMeasurementRow").hide();
    // $("table.order-list tbody tr:first .addMeasurementRow").show();
    $("table.order-list tbody tr .deleteRow").hide();
    $("table.order-list tbody tr:not(:first) .deleteRow").show();

// Function to convert weight and update Gross Weight column
function updateGrossWeight(row) {
   var weight = parseFloat($("input[name='measurements[" + row + "][weight]']").val()) || 0;
   var weightUnit = $("select[name='measurements[" + row + "][weight_unit]']").val();
   var grossWeightCell = $("td.gross-weight").eq(row);

   // Check if weight unit is not selected
   if (!weightUnit) {
       grossWeightCell.text("-"); // Display "-" if no unit is selected
       return false;
   }

   // Convert the weight based on the selected unit
   var convertedWeight = (weightUnit === "2") ? (weight * 2.20462) : (weight / 2.20462);
   // Store gross weight in kg in data attribute
   grossWeightCell.data('kg-value', (weightUnit === "2") ? (convertedWeight / 2.20462) : convertedWeight);

   // Display the weight in the opposite unit
   var displayWeight = (weightUnit === "2") ? convertedWeight.toFixed(2) + " lb" : convertedWeight.toFixed(2) + " kg";
   grossWeightCell.text(displayWeight);

   // Trigger the chargeable weight update
   updateChargeableWeight(row);
}

// Attach change event to weight unit select for immediate conversion update
$("body").on("change", "select[name^='measurements'][name$='[weight_unit]']", function () {
   var row = $(this).closest('tr').index();
   updateGrossWeight(row);
});

// Attach input event to weight input for immediate conversion update
$("body").on("input", "input[name^='measurements'][name$='[weight]']", function () {
   var row = $(this).closest('tr').index();
   updateGrossWeight(row);
});

   // Function to calculate and update volume weight for a single row
function calculateVolumeWeight(row) {
    // Clear the volume weight for the current row
    var volumeWeightCell = $("td.volume-weight").eq(row);
    volumeWeightCell.text("0.00 kg");

    var length = parseFloat($("input[name='measurements[" + row + "][length]']").val());
    var width = parseFloat($("input[name='measurements[" + row + "][width]']").val());
    var height = parseFloat($("input[name='measurements[" + row + "][height]']").val());
    var dimensionUnit = $("select[name='measurements[" + row + "][dimension_unit]']").val();
    var quantity = parseInt($("input[name='measurements[" + row + "][quantity]']").val()) || 1;

    // Check if dimensionUnit is not selected, set volume weight to 0
    if (!dimensionUnit) {
        return;
    }

    if (!isNaN(length) && !isNaN(width) && !isNaN(height)) {
        // Calculate the volume directly by multiplying dimensions
        var volume = length * width * height;
        volume *= quantity; // Multiply by quantity

        // Convert dimensions based on the selected dimension unit
        switch (dimensionUnit) {
            // inch to kg
            case '1':
                volume /= 366; // Convert to kg
                break;
            // cm to kg
            case '2':
                volume /= 6000; // Convert to kg
                break;
            // m to kg
            case '3':
                // Convert meters to inches
                volume *= 39.37;
                volume /= 366; // Convert to kg
                break;
        }

        // Store volume weight in kg in data attribute
        volumeWeightCell.data('kg-value', volume);

        // Display the volume weight in both kg and lb
        volumeWeightCell.text('=' + volume.toFixed(2) + 'kg');
        volumeWeightCell.append("<br>=" + (volume * 2.20462).toFixed(2) + "lb");

        // Trigger the chargeable weight update
        updateChargeableWeight(row);
    }
}

// Function to compare volume weight and gross weight, and update chargeable weight
function updateChargeableWeight(row) {
   var volumeWeightCell = $("td.volume-weight").eq(row);
   var grossWeightCell = $("td.gross-weight").eq(row);
   var chargeableWeightCell = $("td.chargeable-weight").eq(row);

   var volumeWeight = parseFloat(volumeWeightCell.data('kg-value')) || 0;
   var grossWeight = parseFloat(grossWeightCell.data('kg-value')) || 0;

   // Compare volume weight and gross weight
   var chargeableWeight;
   if (volumeWeight >= grossWeight) {
       chargeableWeight = volumeWeight;
       // Convert chargeable weight to lb (1 kg = 2.20462 lb)
      //  var chargeableWeight = chargeableWeight * 2.20462;
        // Display chargeable weight in both kg and lb
        chargeableWeightCell.text('=' + chargeableWeight.toFixed(2) + 'kg');
        chargeableWeightCell.append("<br>=" + (chargeableWeight * 2.20462).toFixed(2) + "lb");
   } else {
       chargeableWeight = grossWeight;
       // Convert chargeable weight to kg
        // Display chargeable weight in both kg and lb
        chargeableWeightCell.text('=' + chargeableWeight.toFixed(2) + 'kg');
        chargeableWeightCell.append("<br>=" + (chargeableWeight * 2.20462).toFixed(2) + "lb");
   }

   // Update chargeable weight in both kg and lb
   chargeableWeightCell.data('kg-value', chargeableWeight);
}

    // Function to calculate and update volume weight for all rows
    function calculateVolumeWeights() {
        $("input[name^='measurements']").each(function () {
            var row = parseInt($(this).attr('name').match(/\d+/));
            calculateVolumeWeight(0);
            calculateVolumeWeight(row);
        });
    }

    function updateAllWeights() {
        $("table.order-list tbody tr").each(function (index) {
            calculateVolumeWeights(index);
            updateGrossWeight(index);
            updateChargeableWeight(index);
        });
    }

    // Calculate volume weights when the page loads
    calculateVolumeWeights();
    calculateVolumeWeight(0);

   // Delayed calculation for the first row
        setTimeout(function () {
            calculateVolumeWeight(0);
            updateGrossWeight(0);
            updateChargeableWeight(0);
        }, 500);

   // Function to calculate volume weight for the first row
    function calculateVolumeWeightForFirstRow() {
    calculateVolumeWeight(0);
    }

   // Set a timeout to initially calculate the volume weight for the first row
    setTimeout(calculateVolumeWeightForFirstRow, 500);

   // Attach keyup event to all input fields to calculate volume weight, gross weight, and chargeable weight whenever any input value changes
   $("body").on("input", "input[name^='measurements'], select[name^='measurements']", function () {
    var row = $(this).closest('tr').index();
    calculateVolumeWeight(row);
    updateGrossWeight(row);
    updateChargeableWeight(row);
    });

        updateAllWeights();

        // Add a new measurement row
        $("body").on("click", ".addMeasurementRow", function () {

        var row = $("table.order-list tbody tr:last");
        var newRow = $("table.order-list tbody tr:last").clone();
        // Update the input names with the new index
        newRow.find("input, select").each(function () {
            var name = $(this).attr("name");
            name = name.replace(/\[(\d+)\]/, "[" + counter + "]");
            $(this).attr("name", name);
            // $(this).val(""); // clear values for new row
        });

            // Validate the last row before adding a new one
            if (validateRow(row)) {
            // Append the new row and increment the counter
            $("table.order-list tbody").append(newRow);
            counter++;
            
            $.notify("New measurement row added.", "success");

            // Attach onchange event to new dimension input fields
            newRow.find('.dimension-input').on('input', function () {
                calculateVolumeWeight($(this).closest('tr').index());
            });

            // Clear gross weight and chargeable weight for the new row
            const newRowGrossWeightCell = newRow.find('td.gross-weight');
            const newRowChargeableWeightCell = newRow.find('td.chargeable-weight');

            newRowGrossWeightCell.text('-');
            newRowChargeableWeightCell.text('-');
        }

            $("table.order-list tbody tr .addMeasurementRow").hide();
            $("table.order-list tbody tr:first .addMeasurementRow").show();
            $("table.order-list tbody tr .deleteRow").hide();
            $("table.order-list tbody tr:not(:first) .deleteRow").show();

        var dimensionUnitSelect = newRow.find("select[name^='measurements[" + counter + "][dimension_unit]']");
        var dimensionUnitOptions = {
         'inch': 'Inches',
         'cm': 'Centimeters',
         'm': 'Meters'
        };

        $.each(dimensionUnitOptions, function (key, value) {
            dimensionUnitSelect.append($('<option>', { value: key, text: value }));
        });
      
        calculateVolumeWeight(counter - 1); // Calculate volume weight for the new row immediately
        updateAllWeights();     // Update gross weight and chargeable weight for all rows after adding a new row
        });

    // Delegated onchange event for dimension_unit select
    $("body").on("change", "select[name^='measurements']", function () {
      calculateVolumeWeight($(this).closest('tr').index());
  });

        // Attach a function to update chargeable weight when volume weight or gross weight changes
        $("body").on("input", "input[name^='measurements'][name$='[weight]'], select[name^='measurements'][name$='[dimension_unit]']", function () {
         var row = $(this).closest('tr').index();
         updateChargeableWeight(row);
     });

    // Delete a measurement row
    $("body").on("click", ".deleteRow", function () {
        $(this).closest("tr").remove();
        $.notify("Measurement row removed.", "danger");
        
        // Update indices after deleting a row
        $("table.order-list tbody tr").each(function (index) {
            $(this).find("input, select").each(function () {
                var name = $(this).attr("name");
                name = name.replace(/\[(\d+)\]/, "[" + index + "]");
                $(this).attr("name", name);
            });
        });

        counter--;

        updateAllWeights();
    });
});