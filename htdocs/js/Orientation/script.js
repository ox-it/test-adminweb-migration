jQuery(document).ready(function($) {

	makeCondition('input[type=radio][name=meet]', 'y', '#meet-info', ['#arrival-date','#arrival-time','#flight-num','#flight-from']);

  // Date pickers
	jQuery('#dob,#arrival-date').datepicker({ dateFormat: "dd/mm/yy" });

});

/*
 * When watch == value (or one of value, if array)
 * wrapper(s) is/are shown, hidden otherwise
 * If target is set, its value is set to '' when wrapper(s) is/are hidden.
 */
function makeCondition(watch, value, wrapper, target) {
  if (!Array.isArray(value)) value = [value];
	jQuery(watch).change(function() {
	  var active = false;
	  if (jQuery(this).is(':checkbox')) active = jQuery(this).is(':checked');
	  else active = value.indexOf(jQuery(this).val().toLowerCase())!=-1;
		if (active) displayElements(wrapper,true);
		else {
		  displayElements(wrapper,false);
		  if (target!='') {
		    if (!Array.isArray(target)) target = [target];
		    for (var t in target) {
		      if (jQuery(target[t]).is(':checkbox')) jQuery(target[t]).attr('checked', false);
		      else if (jQuery(target[t]).is(':radio')) jQuery(target[t]).attr('checked', false);
		      else jQuery(target[t]).val('').trigger("change");
		    }
		  }
		}
	});
	var active = true;
	if (jQuery(watch).is(':checkbox')) active = jQuery(watch).is(':checked');
	else if (jQuery(watch).val()==undefined) active = false;
	else if (jQuery(watch).is(':radio')) {
	  if (jQuery(watch+':checked').val()==undefined) active = false;
	  else active = value.indexOf(jQuery(watch+':checked').val().toLowerCase())!=-1;
	}
	else active = value.indexOf(jQuery(watch).val().toLowerCase())!=-1;
	//alert(watch + ': ' + jQuery(watch).val() + ' ACTIVE:'+(active?'YES':'NO'));
	if (!active) displayElements(wrapper,false);
}

function displayElements(elements,show) {
  if (!Array.isArray(elements)) elements = [elements];
  for (var e in elements) {
    if (show) jQuery(elements[e]).show();
    else 			jQuery(elements[e]).hide();
  }
}