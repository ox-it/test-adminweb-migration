jQuery(document).ready(function($) {

  // Date picker
	//$('#changedate').datepicker({ dateFormat: "dd/mm/yy" });

	$('#lunchSelect').change(function() {
		if ($(this).val().toLowerCase().slice(0,1) != 'n') $('#lunchDietary').show();
		else                                               $('#lunchDietary').hide();
	});

	function disableAttendance(disable) {
		if (disable) $('.attendInput').attr('disabled', 'disabled');
		else $('.attendInput').removeAttr('disabled');
	}

});

