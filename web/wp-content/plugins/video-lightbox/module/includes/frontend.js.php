( function($) {
	if (typeof $.fn.magnificPopup !== 'undefined'){
		$('.fl-module-video-lightbox .bbvl-preview-wrap .bbvl-preview').magnificPopup({
			type: 'iframe',
			mainClass: 'mfp-<?php echo $id ?>',
			removalDelay: 160,
			preloader: false,
			closeOnBgClick: true,
			fixedContentPos: true,
			closeMarkup: '<button title="%title%" type="button" class="mfp-close">X</button>'
		});
	}
})(jQuery);
