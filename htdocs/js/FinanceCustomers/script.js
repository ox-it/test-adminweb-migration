jQuery(document).ready(function($) {

	makeCondition('#deptcode', '00', '#depttext_wrapper', '#depttext');
	makeCondition('input[type=radio][name=category]', 'p', '#custtitle_wrapper', '#custtitle');
	$('#custtitle_wrapper').hide();
	makeCondition('#accounttype', ['a','e'], '#accountnum_wrapper', '#accountnum');
	makeCondition('#payterms', 'o', '#paytermsother_wrapper', '#paytermsother');
	makeCondition('input[type=radio][name=POupload]', 'y', '#POfile_wrapper', '#pofile');
	$('#POfile_wrapper').hide();
	makeCondition('input[type=radio][name=VATflag]', 'y', '#vatcode_wrapper', '#custVAT,#countrycode');
	$('#vatcode_wrapper').hide();
	makeCondition('input[type=radio][name=PDFinvoice]', 'y', '#pdfinvoice_wrapper', '#invoiceemail,#statementemail');
	$('#pdfinvoice_wrapper').hide();
	makeCondition('input[type=radio][name=billcopy]', 'n', '#shipping_wrapper', '#shipaddress1,#shipaddress2,#shipaddress3,#shipaddress4,#shiptown,#shipcounty,#shippostcode,#shipdomcode');
	$('#shipping_wrapper').hide();

});

function makeCondition(watch, value, wrapper, target) {
  if (!Array.isArray(value)) value = [value];
	$(watch).change(function() {
		if (value.indexOf($(this).val().toLowerCase())!=-1) $(wrapper).show();
		else {
		  $(wrapper).hide();
		  $(target).val('');
		}
	});
	if ($(watch).val().toLowerCase() != value) $(wrapper).hide();
}