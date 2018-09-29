jQuery(document).ready(function($) {

  // Check Change Type
  // makeCondition(watch, value, wrapper, target)
	makeCondition('input[type=radio][name=changeType]', 'create', '#newdivision', '');

  //$("#add-another-cost-centre").click(addCCFields);

  for (var i=1; i<11; i++) {
    var clear = ['#costcentresplit'+i];
    for (var j=i+1; j<11; j++) { clear.push('#newcostcentre'+j); clear.push('#costcentresplit'+j); }
    makeCondition('#newcostcentre'+i, '', '#cost-centre-'+(i+1), clear);
  }

  // Menu
  $( "#pras-select-menu" ).menu({
		position: {
		  my: "left top", at: "left+104% 0", collision:'none',
		  using: function(a,b) {
        $(this).css({ 'left':a.left , 'top':0 });
		  }
		}
	});
	var maxHeight = Math.max.apply(null, $("#pras-select-menu ul").map(function () {
    return $(this).height();
  }).get());
	$( "#pras-select-menu" ).height(maxHeight);

  // Date picker
	$('#changedate').datepicker({
		dateFormat: "dd/mm/yy"
	});
});

/*
 * Taken from the original WAF, and wrapped
 */
/*
//(function($) {
  function addCCFields() {
    var removeButton = jQuery('<button class="removeCCField" type="button">Remove</button>');
    var clone = jQuery(".newCostCentre:first").clone();
    clone.append(removeButton);
    $("#add-another-cost-centre").before(clone);
    //jQuery('option', clone).removeAttr('selected');
    //jQuery('option:first', clone).attr('selected', 'selected');
    //jQuery('input', clone).val(0);
    //jQuery(".newCostCentre:last", "#newCostCentresArea").after(clone);
    removeButton.click(removeCCField);
    correctCostCentreIds();
  }

	function removeCCField(e){
		jQuery(e.target).parent().remove();
		correctCostCentreIds();
	}

	function correctCostCentreIds() {
		jQuery(".newCostCentre").each(function(i, v){
			var id = i + 1;
			jQuery(v).find('label:first').attr('for', 'newCostCentre' + id);
			jQuery(v).find('select').attr('id', 'newCostCentre' + id);
			jQuery(v).find('select').attr('name', 'newCostCentre' + id);
			jQuery(v).find('label:last').attr('for', 'costCentreSplit' + id);
			jQuery(v).find('input').attr('id', 'costCentreSplit' + id);
			jQuery(v).find('input').attr('name', 'costCentreSplit' + id);
		});
	}
//})(jQuery);
//*/

/*
 * When watch == value (or one of value, if array)
 * wrapper(s) is/are shown, hidden otherwise
 * If target is set, its value is set to '' when wrapper(s) is/are hidden.
 */
function makeCondition(watch, value, wrapper, target) {
  if (!Array.isArray(value)&&value!='') value = [value];
	jQuery(watch).change(function() {
	  var active = false;
	  if (jQuery(this).is(':checkbox')) active = jQuery(this).is(':checked');
	  else {
			if (Array.isArray(value)) {
			  active = value.indexOf(jQuery(this).val().toLowerCase())!=-1;
			} else {
			  active = (jQuery(this).val().toLowerCase()!='');
			}
	  }
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
  	//alert(watch + ' = ' + jQuery(watch).val());
	  var active = true;
	  if (jQuery(watch).is(':checkbox') || jQuery(watch).is(':radio')) active = jQuery(watch).is(':checked');
	  else {
			if (Array.isArray(value)) {
			  active = value.indexOf(jQuery(watch).val().toLowerCase())!=-1;
			} else {
			  active = (jQuery(watch).val().toLowerCase()!='');
			}
	  }
		if (!active) displayElements(wrapper,false);
	}
}

function displayElements(elements,show) {
  if (!Array.isArray(elements)) elements = [elements];
  //alert((show?'Showing':'Hiding')+' '+elements.join(', '));
  for (var e in elements) {
    if (show) jQuery(elements[e]).show();
    else 			jQuery(elements[e]).hide();
  }
}