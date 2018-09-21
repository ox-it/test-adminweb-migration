jQuery(document).ready(function($) {
  jQuery('.accord').each(function(e) {
	  jQuery(this).find('.morelessg-content').hide();
	  /*
	  $parent = jQuery(this);
	  jQuery(this).find('a.oxToggleMoreLess').click(function({ parent:$parent }, c) {
	    alert('click');
	    var $content = c.data.parent.find('.morelessg-content');
      if ($content.is(":visible")) {
        $content.hide();
      } else {
        $content.show();
      }
	  });
	  //*/
	});
});

