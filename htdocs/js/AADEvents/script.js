jQuery(document).ready(function($) {

	jQuery('#deptcode').change(function() {
		if (jQuery(this).val().toLowerCase() == '00') jQuery('#depttext_wrapper').show();
		else {
		  jQuery('#depttext_wrapper').hide();
		  jQuery('#depttext').val('');
		}
	});

	if (jQuery('#deptcode').val().toLowerCase() != '00') jQuery('#depttext_wrapper').hide();

});

