jQuery(document).ready(function($) {

  // Check Change Type
	makeCondition('#application-type', ['single','joint','couple/family'], ['#applicant1','#accommodation','#buttons'], '');
	makeCondition('#application-type', ['joint','couple/family'], '#family', '');
	makeCondition('#application-type', ['joint'], '#applicant2', '');
	makeCondition('#application-type', ['couple/family'], '#spouse', '');

	makeCondition('#title', 'other', '#title-other-wrapper', '#title-other');
	makeCondition('#degree', 'other', '#degree-other-wrapper', '#degree-other');
	makeCondition('#partner-title', 'other', '#partner-title-other-wrapper', '#partner-title-other');
	makeCondition('#partner-degree', 'other', '#partner-degree-other-wrapper', '#partner-degree-other');
	makeCondition('#spouse-title', 'other', '#spouse-title-other-wrapper', '#spouse-title-other');

	makeCondition('#select-child-1', ['male','female'], '#child-2', ['#child-dob-1','#select-child-2','#child-dob-2','#select-child-3','#child-dob-3','#select-child-4','#child-dob-4','#select-child-5','#child-dob-5','#select-child-6','#child-dob-6']);
	makeCondition('#select-child-2', ['male','female'], '#child-3', ['#child-dob-2','#select-child-3','#child-dob-3','#select-child-4','#child-dob-4','#select-child-5','#child-dob-5','#select-child-6','#child-dob-6']);
	makeCondition('#select-child-3', ['male','female'], '#child-4', ['#child-dob-3','#select-child-4','#child-dob-4','#select-child-5','#child-dob-5','#select-child-6','#child-dob-6']);
	makeCondition('#select-child-4', ['male','female'], '#child-5', ['#child-dob-4','#select-child-5','#child-dob-5','#select-child-6','#child-dob-6']);
	makeCondition('#select-child-5', ['male','female'], '#child-6', ['#child-dob-5','#select-child-6','#child-dob-6']);
	makeCondition('#select-child-6', ['male','female'], '', '#child-dob-6');

	jQuery('#application-type').change(function() { updateSectionNumbers(); });

  // Date picker
	jQuery('#degree-start,#partner-degree-start,#child-dob-1,#child-dob-2,#child-dob-3,#child-dob-4,#child-dob-5,#child-dob-6,#tenancy-accept').datepicker({ dateFormat: "dd/mm/yy" });

	updateSectionNumbers();

});

/*
 * When watch == value (or one of value, if array)
 * wrapper(s) is/are shown, hidden otherwise
 * If target is set, its value is set to '' when wrapper(s) is/are hidden.
 */
function makeCondition(watch, value, wrapper, target) {
  if (!Array.isArray(value)) value = [value];
	jQuery(watch).change(function() {
		if (value.indexOf(jQuery(this).val().toLowerCase())!=-1) displayElements(wrapper,true);
		else {
		  displayElements(wrapper,false);
		  if (target!='') {
		    if (!Array.isArray(target)) target = [target];
		    for (var t in target) jQuery(target[t]).val('').trigger("change");
		  }
		}
	});
	if (jQuery(watch).val()==undefined || value.indexOf(jQuery(watch).val().toLowerCase())==-1) displayElements(wrapper,false);
}

function displayElements(elements,show) {
  //console.log((show?"Show":'Hide') + ' ' + elements);
  if (!Array.isArray(elements)) elements = [elements];
  for (var e in elements) {
    if (show) jQuery(elements[e]).show();
    else 			jQuery(elements[e]).hide();
  }
}

function updateSectionNumbers() {
  var count=1;
  jQuery('.section-number').each(function(index) {
    if (jQuery(this).is(":visible")) {
      jQuery(this).html(count);
      count++;
    }
  });
}