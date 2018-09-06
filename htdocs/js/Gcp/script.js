jQuery(document).ready(function($) {

  // Conditions - make values lowercase
	makeCondition('#employer', 'o', '#waf-gcp-external', ['#study','#investigator','#REC','#project']);

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
	if (jQuery(watch).val()==undefined) displayElements(wrapper,false);
	else {
	  var active = true;
	  if (jQuery(watch).is(':checkbox')) active = jQuery(watch).is(':checked');
	  else active = value.indexOf(jQuery(watch).val().toLowerCase())!=-1;
		if (!active) displayElements(wrapper,false);
	}
}

function displayElements(elements,show) {
  if (!Array.isArray(elements)) elements = [elements];
  for (var e in elements) {
    if (show) jQuery(elements[e]).show();
    else 			jQuery(elements[e]).hide();
  }
}