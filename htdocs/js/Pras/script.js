jQuery(document).ready(function($) {

  // Check Change Type
	$('#changetype,#entitytype').on('change', function() {
	  var changeType = $('#changetype').val();
	  var entityType = $('#entitytype').val();
		alert( 'Change: ' + changeType + '   Entity: ' + entityType);
	});

  // Menu
  $( "#pras-select-menu" ).menu();

  // Date picker
	$('#changedate').datepicker({
		dateFormat: "dd/mm/yy"
	});
});