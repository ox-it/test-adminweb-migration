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
	$(watch).change(function() {
	  var active = false;
	  if ($(this).is(':checkbox')) active = $(this).is(':checked');
	  else active = value.indexOf($(this).val().toLowerCase())!=-1;
		if (active) displayElements(wrapper,true);
		else {
		  displayElements(wrapper,false);
		  if (target!='') {
		    if (!Array.isArray(target)) target = [target];
		    for (var t in target) {
		      if ($(target[t]).is(':checkbox')) $(target[t]).attr('checked', false);
		      else if ($(target[t]).is(':radio')) $(target[t]).attr('checked', false);
		      else $(target[t]).val('').trigger("change");
		    }
		  }
		}
	});
	if ($(watch).val()==undefined) displayElements(wrapper,false);
	else {
	  var active = true;
	  if ($(watch).is(':checkbox')) active = $(watch).is(':checked');
	  else active = value.indexOf($(watch).val().toLowerCase())!=-1;
		if (!active) displayElements(wrapper,false);
	}
}

function displayElements(elements,show) {
  if (!Array.isArray(elements)) elements = [elements];
  for (var e in elements) {
    if (show) $(elements[e]).show();
    else 			$(elements[e]).hide();
  }
}