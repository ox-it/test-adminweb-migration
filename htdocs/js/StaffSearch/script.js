jQuery(document).ready(function($) {
	var close = '<span class="contact-close">Close</span>';
  jQuery('.contact-search-container').each(function(e) {
    var id = jQuery(this).attr('id');
    if (jQuery(this).find('.contact-results').html()!='') {
			jQuery(this).find('.contact-results').prepend(close).find('.contact-close').click(function() {
				jQuery(this).parent().slideUp('slow');
			});
    }

		// Activate pager
		var $pager = jQuery(this).find('.page-links');
		if ($pager) {
      var $data = jQuery(this).find('.contact-results .contact-results-list li');

			$pager.showpage = function(page) {
	  	  $currentPage = $pager.find('.active');
        $currentPage.removeClass('active');
        $newPage = $pager.find('.page-'+page);
        $newPage.addClass('active');
        $data.hide();
        jQuery('#'+id+'.contact-search-container .person-page-'+page).show();
        jQuery('#'+id+'.contact-search-container .currentPage').html(page);
  		};

			$pager.find('li.link').each(function(e) {
				jQuery(this).click(function() {
					$pager.showpage(jQuery(this).find('span').html());
					return false;
				});
			});

			$pager.find('li.prev').click(function() {
				var currentPage = parseInt($pager.find('.active span').html());
				if (currentPage>1) $pager.showpage(currentPage-1);
				return false;
			});

			$pager.find('li.next').click(function() {
				var currentPage = parseInt($pager.find('.active span').html());
				if (currentPage<$pager.find('li.link').length) $pager.showpage(currentPage+1);
				return false;
			});

		}

	});
});

