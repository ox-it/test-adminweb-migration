jQuery(document).ready(function($) {

	makeCondition('#air', '#air_wrapper');
	makeCondition('#train', '#train_wrapper');
	makeCondition('#car', '#car_wrapper');
	makeCondition('#hotel', '#hotel_wrapper');

  // Date pickers
	$('#airdateout,#airdateback,#traindateout,#traindateback,#cardatestart,#cardateend,#hoteldatestart,#hoteldateend').datepicker({ dateFormat: "dd/mm/yy" });

});

function makeCondition(watch, wrapper, target) {
	$(watch).change(function() {
		if ($(this).is(':checked')) $(wrapper).show();
		else $(wrapper).hide();
	});
	if (!$(watch).is(':checked')) $(wrapper).hide();
}