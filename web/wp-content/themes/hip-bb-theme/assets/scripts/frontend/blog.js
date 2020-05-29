(function($) {
	"use strict";

	$(document).ready(function(){
		$('.fl-post-feed-post').each(function(){
			var imgDiv = $(this).find('.post-featured-image');
			var imgUrl = imgDiv.html();
			imgDiv.css({
				'background-image' : 'url(' + imgUrl + ')',
				'opacity' : '1'
			});
		});

		/* Blog archive 2 post blocks height*/
		$(window).on('load resize',function(){
			if($(window).width() > 600){

				makeEqualHeightBlocks('body:not(.paged) .blog-archive-2 .pp-posts-wrapper .pp-content-post-grid .pp-content-post',true);
				makeEqualHeightBlocks('body.paged .blog-archive-2 .pp-posts-wrapper .pp-content-post-grid .pp-content-post');

			}else{
				$('.blog-archive-2 .pp-posts-wrapper .pp-content-post-grid .pp-content-post').each(function(){
					$(this).height('auto');
				})
			}
		});
		if('objectFit' in document.documentElement.style === false){
			$('.blog-archive-2 .pp-posts-wrapper .pp-content-post-grid .pp-content-post').each(function(){
				$(this).find('.pp-post-featured-img .fl-photo .fl-photo-content a').addClass('no-object-fit');
			});
		}

		var makeEqualHeightBlocks = function(blocks, excludeFirst){
			excludeFirst = excludeFirst || false;
			$(blocks).each(function(i) {
				$(this).height('unset');
			});

			var heights = $(blocks).map(function () {
				return $(this).height();
			}).get();

			// Remove first element
			if(excludeFirst === true){
				heights.shift();
			}

			var maxheight = Math.max.apply( null, heights );

			$(blocks).each(function(i){
				if(excludeFirst){
					if ( i > 0 ) {
						$(this).height(maxheight + 80 );
						$(this).css('max-height', maxheight + 80 + 'px')
					}
				}else{
					$(this).height(maxheight + 80 );
					$(this).css('max-height', maxheight + 80 + 'px')
				}

			});
		}
	});
})(jQuery);
