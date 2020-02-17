jQuery(document).ready(function($) {

	// Check Change Type
	makeCondition('#application-type-single', ['single','joint','couple/family'], ['#applicant1','#accommodation','#buttons'], '');
	makeCondition('#application-type-joint', ['joint'], ['#applicant1', '#accommodation','#buttons', '#family', '#applicant2'], '');
	makeCondition('#application-type-couple-family ', ['couple/family'], ['#applicant1','#accommodation','#buttons', '#spouse', '#family'], '');

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

	jQuery("input[name='application_type']").change(function(e) { requiredFields(); updateSectionNumbers(); updateAccommodationTypes(e); });
	jQuery('#acc-prefer-1').change(function() { updatePreferences('#acc-prefer-1','#acc-prefer-2'); }).trigger('change');
	jQuery('#acc-prefer-3').change(function() { updatePreferences('#acc-prefer-3','#acc-prefer-4'); }).trigger('change');

	// Date picker
	jQuery('#degree-start,#partner-degree-start,#child-dob-1,#child-dob-2,#child-dob-3,#child-dob-4,#child-dob-5,#child-dob-6,#tenancy-accept').datepicker({ dateFormat: "dd/mm/yy" });

	jQuery('label[for="application-type-single"]').append(': Apply for accommodation suitable for one student');
	jQuery('label[for="application-type-joint"]').append(': Apply for accommodation suitable for a couple / family (where both adults are full-time graduate students of the University of Oxford)');
	jQuery('label[for="application-type-couple-family"]').append(': Apply for accommodation suitable for a couple / family (where only one adult occupant is a full-time graduate student of the University of Oxford)');

	updateSectionNumbers();
	requiredFields();
	
});


/*
* Make sure the correct fileds are marked as required depending on application type.
*/
function requiredFields() {
	var application_type = jQuery("input[name='application_type']:checked").val();
	var requiredAll = ['#degree-start', '#title','#surname','#firstname','#contact-number','#preferred-email','#nationality','#college','#degree','#subject','#term','#term-year','#acc-prefer-1','#acc-prefer-2','#tenancy-accept'];
	var requiredJoint = ['#partner-title','#partner-lastname','#partner-firstname','#partner-relationship','#partner-nationality','#partner-preferred-email','#partner-contact-no','#partner-college','#partner-degree','#partner-subject','#partner-degree-start'];
	var requiredFamily = ['#spouse-title','#spouse-firstname','#spouse-lastname','#spouse-relationship','#spouse-nationality'];
	
	jQuery('div.required').removeClass('required');
	
	jQuery(requiredAll).each(function(i,v) {
		jQuery(v).closest('div').addClass('required');
	});
	
	if (typeof application_type !== 'undefined' && application_type === 'Joint') {
		jQuery(requiredJoint).each(function(i,v){
			jQuery(v).closest('div').addClass('required');
		});
	}
	else if (typeof application_type !== 'undefined' && application_type === 'Couple/Family') {
		jQuery(requiredFamily).each(function(i,v){
			jQuery(v).closest('div').addClass('required');
		});
	}
	
}

/*
 * When watch == value (or one of value, if array)
 * wrapper(s) is/are shown, hidden otherwise
 * If target is set, its value is set to '' when wrapper(s) is/are hidden.
 */
function makeCondition(watch, value, wrapper, target) {
	var form_elements = ['#applicant1','#accommodation','#buttons', '#family', '#applicant2', '#spouse'];
	
	if (!Array.isArray(value)) value = [value];
	
	jQuery(watch).change(function() {
		if(watch.lastIndexOf('#application-type', 0)=== 0) { 
			displayElements(form_elements, false);
		}
		if (value.indexOf(jQuery(this).val().toLowerCase())!=-1) {
			displayElements(wrapper,true);
		}
		else {
			if (target!='') {
				if (!Array.isArray(target)) target = [target];
				for (var t in target) jQuery(target[t]).val('').trigger("change");
			}
		}
	});

	if (jQuery(watch).prop('type') === 'radio' && jQuery(watch).prop("checked") === true) {
		displayElements(form_elements, false);
		displayElements(wrapper,true);
	}
	else if (jQuery("input[name='application_type']:checked").length === 0 || jQuery(watch).val()==undefined || value.indexOf(jQuery(watch).val().toLowerCase())==-1) {
		displayElements(wrapper,false);
	}
}

function displayElements(elements,show) {

	if (!Array.isArray(elements)) elements = [elements];

	for (var e in elements) {
		if (show) {
			jQuery(elements[e]).show();
		}
		else {
			jQuery(elements[e]).hide();
		}
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

function updateAccommodationTypes(event) {
	var type = event.target.value;
	var acc_type = [ "Room",  "Ensuite", "Bedsit", "Single Studio", "Double Studio", "One Bed Flat", "Two Bed Flat", "Three Bed Flat", "Two Bed House", "Three Bed House" ];
	var include_types = (type=='Single') ? [0,1,2,3] : [4,5,6,7,8,9];
	var options = '<option value="" selected>-- Please Select --</option>';

	for (var i=0;i<include_types.length;i++) {
		var index = include_types[i];
		options += '<option value="'+ acc_type[index] + '">' + acc_type[index] + '</option>';
	}
	
	jQuery('#acc-prefer-1').html(options);
	jQuery('#acc-prefer-2').html('');
	jQuery('#acc-prefer-3').html(options);
	jQuery('#acc-prefer-4').html('');
}

function updatePreferences(source,target) {
	var type = jQuery(source).val();
	var acc_type = [ "Room",  "Ensuite", "Bedsit", "Single Studio", "Double Studio", "One Bed Flat", "Two Bed Flat", "Three Bed Flat", "Two Bed House", "Three Bed House" ];
	var type_index = acc_type.indexOf(type);
	var type_options = [
		/*Room*/ ['STH|Summertown House','147WS|147 Walton Street','CPG|Court Place Gardens'],
		/* Ensuite */ ['CM|Castle Mill','JSL|Jack Straws Lane','CC|Cavalier Court'],
		/* Bedsit */ ['STH|Summertown House'],
		/*Single Studio*/ ['CM|Castle Mill', 'STH|Summertown House'],
		/*Double Studio*/ ['ABC|Alan Bullock Close', 'CM|Castle Mill', 'STH|Summertown House'],
		/*One Bed Flat*/ ['STH|Summertown House', 'CM|Castle Mill', '25WS|25 Wellington Square'],
		/*Two Bed Flat*/ ['ABC|Alan Bullock Close', 'CM|Castle Mill', 'STH|Summertown House', '134138WS|134-138 Walton Street'],
		/*Three Bed Flat*/ ['ABC|Alan Bullock Close'],
		/*Two Bed House*/ ['CPG|Court Place Gardens'],
		/*Three Bed House*/ ['CPG|Court Place Gardens']
	];
	var include_types = type_options[type_index];
	var options = '<option value="" selected>-- Please Select --</option>';
  
	if (typeof include_types !== 'undefined') {
		for (var i=0;i<include_types.length;i++) {
			var option = include_types[i];
			var parts = option.split("|");
			options += '<option value="'+ parts[0] + '">' + parts[1] + '</option>';
		}
		jQuery(target).html(options);
	} else {
		jQuery(target).html('');
	}
	
}
