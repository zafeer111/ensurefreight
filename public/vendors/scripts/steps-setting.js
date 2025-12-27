$(".booking-wizard").steps({
	headerTag: "h5",
	bodyTag: "section",
	transitionEffect: "fade",
	titleTemplate: '<span class="step">#index#</span> #title#',
	labels: {
		finish: "Submit Booking"
	},
	onStepChanging: function (event, currentIndex, newIndex) {
        // Check if the current step is the first step
        if (currentIndex === 0) {
            // Check if the first step is not validated
            if (!validateStep1()) {
                // If not validated, prevent moving to the next step
				$.notify("Complete Bill of Lading first", "error");
                return false;
            }
        }
        // Disable previous steps
        $('.steps .current').prevAll().addClass('disabled');
        // Allow step change
        return true;
    },
	onStepChanged: function (event, currentIndex, priorIndex) {
		$('.steps .current').prevAll().addClass('disabled');
	},
	onFinished: function (event, currentIndex) {
		$('#success-modal').modal('show');
	}
});