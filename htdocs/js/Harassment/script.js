jQuery(document).ready(function($) {

  // Conditions
	makeCondition('#22fadviceother', '1', '#22f-wrapper', '#22fadviceotherdetails');
	makeCondition('#3hother', '1', '#3ho-wrapper', '#3hotherdetails');
	makeCondition('#4gother', '1', '#4go-wrapper', '#4gotherdetails');
	makeCondition('#62agrievance', '1', '#62-wrapper', ['#grievance-62u','#grievance-62n']);
	makeCondition('#62bdisciplinary', '1', '#62bo-wrapper', '#62bdisciplinaryaction');
	makeCondition('#62cformalother', '1', '#62co-wrapper', '#62cformalotherdetails');
	makeCondition('#72eother', '1', '#72eo-wrapper', '#72fotherdetails');
	makeCondition('#81bapproachthird', '1', '#81bo-wrapper', '#81bapproachthirddetails');
	makeCondition('#81cotheraction', '1', '#81co-wrapper', '#81cotheractiondetails');
	makeCondition('#82creferred', '1', '#82co-wrapper', '#82creferreddetails');

  // Date picker
	//$('#degree-start,#partner-degree-start,#child-dob-1,#child-dob-2,#child-dob-3,#child-dob-4,#child-dob-5,#child-dob-6,#tenancy-accept').datepicker({ dateFormat: "dd/mm/yy" });

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