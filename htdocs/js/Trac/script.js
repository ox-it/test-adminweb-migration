jQuery(document).ready(function($) {

	var absents = ['xsic','xhol','xsab','xmat','xoth'];
	var teaching = ['a01','a02','a43','a53','a04','a07','a48','a58','a21','a22','a63','a73','a24','a27','a68','a78','b17','a33','b88','b98','a08'];
	var b1s = ['b11','b12','b13','b14'];
	var b2s = ['b21','b22','b23','b24','b25','b26'];
	var b3s = ['b31'];
	var bs = b1s.concat(b2s, b3s);
	var cs = ['c1','c1a','c2','c3','c4','c5','c6'];
	var ds = ['d11','d12','d21','d13'];
	var other = bs.concat(cs, ds);

  // Conditional
  makeCondition('#absent', 'y', '#absence', absents);

  // Expandable
	makeExpandable(['#note1','#note2','#note3','#note4']);

	// Autocalcs
	autoHoursPercFromDays(absents.concat(['xt']));
	autoHoursPercFromTeaching(teaching.concat(['abt']));
	autoPercFromHours(other.concat(['b1t','b2t','bt','ct','dt','tt']));

	// Totals
	autoTotal('#xt-d',absents,'-d');
	autoTotal('#abtd',teaching,'d');
	autoTotal('#abta',teaching,'a');
	autoTotal('#b1t-h',b1s,'-h');
	autoTotal('#b2t-h',b2s,'-h');
	autoTotal('#bt-h',b3s.concat(['b1t','b2t']),'-h');
	autoTotal('#ct-h',cs,'-h');
	autoTotal('#dt-h',ds,'-h');
	autoTotal('#tt-h',['xt-h','abtd','abta','bt-h','ct-h','dt-h'],'');

  // Date picker
	//$('#degree-start').datepicker({ dateFormat: "dd/mm/yy" });

});

function autoTotal(target, source, suffix) {
	var sids = []; for (s in source) { sids.push('#'+source[s]+suffix); }
  jQuery(sids.join(',')).change({'target':target,'sids':sids},function(e) {
    var total = 0.0;
    //var msg = e.data.target + ' ';
    for (var s in e.data.sids) {
      var value = jQuery(e.data.sids[s]).val();
      total += (value==undefined || value=='') ? 0.0 : parseFloat(value);
      //msg += (value=='') ? '' : ' +' + parseFloat(value);
    }
    //alert(msg + ' = ' + total);
    jQuery(e.data.target).val(total).trigger("change");
  });
  jQuery(sids[0]).trigger("change");

  jQuery('#pftw').change(function(e) {
	  jQuery(sids.join(',')).trigger("change");
	});
}

function autoHoursPercFromDays(tags) {
  if (!Array.isArray(tags)) tags = [tags];
  for (var t in tags) {
    var $days = jQuery('#'+tags[t]+'-d');
    $days.change({'tag':tags[t]}, function(event) {
      var total = getTotalHours();
      var d = jQuery(this).val();
      var days =  (d=='') ? 0.0 : parseFloat(d);
			var $hour = jQuery('#'+event.data.tag+'-h');
			var $perc = jQuery('#'+event.data.tag+'-p');
			$hour.val(parseFloat(days * 7.5).toFixed(2));
			$perc.val(parseFloat((days * 750) / total).toFixed(1));
			jQuery(this).val(days==0.0 ? '' : days.toFixed(2));
    });
    $days.trigger("change");
  }
}

function autoHoursPercFromTeaching(tags) {
  if (!Array.isArray(tags)) tags = [tags];
  for (var t in tags) {
    jQuery('#'+tags[t]+'d,#'+tags[t]+'a').change({'tag':tags[t]}, function(e) {
			var direct = jQuery('#'+e.data.tag+'d').val();
			var assess = jQuery('#'+e.data.tag+'a').val();
			direct = ((direct==undefined || direct=='') ? 0.0 : parseFloat(direct));
			assess = (assess=='' ? 0.0 : parseFloat(assess));
			jQuery('#'+e.data.tag+'d').val(direct==0.0 ? '' : parseFloat(direct).toFixed(2));
			jQuery('#'+e.data.tag+'a').val(assess==0.0 ? '' : parseFloat(assess).toFixed(2));
			var sum = (direct + assess);
      var total = getTotalHours();
			var $hour = jQuery('#'+e.data.tag+'-hour');
			var $perc = jQuery('#'+e.data.tag+'-perc');
			$hour.val(parseFloat(sum).toFixed(2));
			$perc.val(parseFloat((sum * 100) / total).toFixed(1));
    });
    jQuery('#'+tags[t]+'a').trigger("change");
  }
}

function autoPercFromHours(tags) {
  if (!Array.isArray(tags)) tags = [tags];
  for (var t in tags) {
    var $hours = jQuery('#'+tags[t]+'-h');
    $hours.change({'tag':tags[t]}, function(e) {
      var total = getTotalHours();
      var h = jQuery(this).val();
      var hours =  (h=='') ? 0.0 : parseFloat(h);
			var $perc = jQuery('#'+e.data.tag+'-p');
			$perc.val(parseFloat((hours * 100) / total).toFixed(1));
			jQuery(this).val(hours==0.0 ? '' : hours.toFixed(2));
    });
    $hours.trigger("change");
  }
}

function getTotalHours() {
  var pftw = jQuery('#pftw').val();
  var total = 37.5;
  if (pftw!='') total = parseFloat(jQuery('#pftw').val()) * 0.375;
  return total;
}


function makeExpandable(blocks) {
  if (!Array.isArray(blocks)) blocks = [blocks];
  for (var b in blocks) {
    var $block = jQuery(blocks[b]);
    var id = $block.attr('id');
    $block.before('<div id="' + id + '-button" class="toggle" target="'+id+'" status="closed">Show Notes</div>');
    jQuery('#'+id+'-button').click(function() {
			if (jQuery(this).attr('status')=='closed') {
			  jQuery('#'+jQuery(this).attr('target')).slideDown();
			  jQuery(this).attr('status','open');
			  jQuery(this).html('Hide Notes');
			} else {
			  jQuery('#'+jQuery(this).attr('target')).slideUp();
			  jQuery(this).attr('status','closed');
			  jQuery(this).html('Show Notes');
			}
		});
		$block.hide();
  }
}

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