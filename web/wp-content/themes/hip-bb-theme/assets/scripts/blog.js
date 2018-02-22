(function($) {
    "use strict";

	$(document).ready(function(){
		$('.fl-post-feed-post').each(function(){
			var imgDiv = $(this).find('.post-featured-image');
			var imgUrl = imgDiv.html();
			imgDiv.html('');
			imgDiv.css({
				'background-image' : 'url(' + imgUrl + ')',
				'opacity' : '1'
			});
		});
	});
})(jQuery);