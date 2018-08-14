jQuery(document).ready(function($) {

	$('#deptcode').change(function() {
		if ($(this).val().toLowerCase() == '00') $('#depttext_wrapper').show();
		else {
		  $('#depttext_wrapper').hide();
		  $('#depttext').val('');
		}
	});

	if ($('#deptcode').val().toLowerCase() != '00') $('#depttext_wrapper').hide();

});

