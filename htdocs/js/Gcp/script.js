jQuery(document).ready(function($) {

	jQuery('#waf-gcp-external').hide();
	var mandatoryIfOtherEmployer = ['#study','#investigator','#rec'];
	mandatoryIfOtherEmployer.forEach((selector) => {
		jQuery(selector).parent().addClass('required');
	});

	if (jQuery('#employer').val().toLowerCase() == 'o') {
		jQuery('#waf-gcp-external').show();
	}

	jQuery('#employer').change(function() {
		var active = false;
		active = jQuery(this).val().toLowerCase() == 'o';
		mandatoryIfOtherEmployer.forEach((selector) => {
			jQuery(selector).attr("required", active);
		});
		if (active) {
			jQuery('#waf-gcp-external').show();
		} else {
			jQuery('#waf-gcp-external').hide();
			jQuery('#waf-gcp-external input').val('');
		}
	});

});
