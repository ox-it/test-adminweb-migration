jQuery(document).ready(function($) {

  // Date picker
	//jQuery('#changedate').datepicker({ dateFormat: "dd/mm/yy" });

	$('#lunchSelect').change(function() {
		if (jQuery(this).val().toLowerCase().slice(0,1) != 'n') jQuery('#lunchDietary').show();
		else                                               jQuery('#lunchDietary').hide();
	});

	function disableAttendance(disable) {
		if (disable) jQuery('.attendInput').attr('disabled', 'disabled');
		else jQuery('.attendInput').removeAttr('disabled');
	}

});

