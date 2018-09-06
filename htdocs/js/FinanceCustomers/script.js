jQuery(document).ready(function($) {

	makeCondition('#deptcode', '00', '#depttext_wrapper', '#depttext');
	makeCondition('input[type=radio][name=category]', 'p', '#custtitle_wrapper', '#custtitle');
	jQuery('#custtitle_wrapper').hide();
	makeCondition('#accounttype', ['a','e'], '#accountnum_wrapper', '#accountnum');
	makeCondition('#payterms', 'o', '#paytermsother_wrapper', '#paytermsother');
	makeCondition('input[type=radio][name=POupload]', 'y', '#POfile_wrapper', '#pofile');
	jQuery('#POfile_wrapper').hide();
	makeCondition('input[type=radio][name=VATflag]', 'y', '#vatcode_wrapper', '#custVAT,#countrycode');
	jQuery('#vatcode_wrapper').hide();
	makeCondition('input[type=radio][name=PDFinvoice]', 'y', '#pdfinvoice_wrapper', '#invoiceemail,#statementemail');
	jQuery('#pdfinvoice_wrapper').hide();
	makeCondition('input[type=radio][name=billcopy]', 'n', '#shipping_wrapper', '#shipaddress1,#shipaddress2,#shipaddress3,#shipaddress4,#shiptown,#shipcounty,#shippostcode,#shipdomcode');
	jQuery('#shipping_wrapper').hide();

});

function makeCondition(watch, value, wrapper, target) {
  if (!Array.isArray(value)) value = [value];
	jQuery(watch).change(function() {
		if (value.indexOf(jQuery(this).val().toLowerCase())!=-1) jQuery(wrapper).show();
		else {
		  jQuery(wrapper).hide();
		  jQuery(target).val('');
		}
	});
	if (jQuery(watch).val().toLowerCase() != value) jQuery(wrapper).hide();
}