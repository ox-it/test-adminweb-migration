jQuery(document).ready(function($) {

	makeCondition('#air', '#air_wrapper');
	makeCondition('#train', '#train_wrapper');
	makeCondition('#car', '#car_wrapper');
	makeCondition('#hotel', '#hotel_wrapper');

  // Date pickers
	jQuery('#airdateout,#airdateback,#traindateout,#traindateback,#cardatestart,#cardateend,#hoteldatestart,#hoteldateend').datepicker({ dateFormat: "dd/mm/yy" });

});

function makeCondition(watch, wrapper, target) {
	jQuery(watch).change(function() {
		if (jQuery(this).is(':checked')) jQuery(wrapper).show();
		else jQuery(wrapper).hide();
	});
	if (!jQuery(watch).is(':checked')) jQuery(wrapper).hide();
}