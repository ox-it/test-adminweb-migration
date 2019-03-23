jQuery(document).ready(function($) {
	var more = "+ more";
	var less = "- less";
  jQuery('.accord').each(function(e) {
	  jQuery(this).find('.morelessg-content').hide();
	  // Taken from http://www.admin.ox.ac.uk/media/global/wwwadminoxacuk/styleassets/js/all.js
    jQuery(this).find('a[data-behaviour=oxToggleMoreLess]').click(function() {
        var $this = jQuery(this);
        var $content = $this.parents('.morelessg-text').children('.morelessg-content');
        $content.slideToggle('slow', function() {
            if ($content[0].style.display == 'block') {
                $content.parent().find("a[data-behaviour=oxToggleMoreLess]").html(less);
            } else {
                $content.parent().find("a[data-behaviour=oxToggleMoreLess]").html(more);
            }
        });
    });
	});
});

