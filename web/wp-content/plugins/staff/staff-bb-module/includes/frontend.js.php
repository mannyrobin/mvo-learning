<?php

	// set defaults
	$autoplay = ! empty( $settings->speed ) ? $settings->speed * 1000 : '1000';
	$speed = ! empty( $settings->transitionDuration ) ? $settings->transitionDuration * 1000 : '1000';

	?>

(function($) {

	$(function() {
	
		new FLBuilderPostSlider({
			id: '<?php echo $id ?>',
		<?php if ( isset( $settings->navigation ) && $settings->navigation == 'yes' ) : ?>
			navigationControls: true,
		<?php endif; ?>
			settings: {
                mode: 'fade',
			<?php if ( isset( $settings->pagination ) && $settings->pagination == 'no' ) : ?>
				pager: false,
			<?php endif; ?>
				speed: <?php echo $speed ?>,
				infiniteLoop: true,
				adaptiveHeight: true,
				controls: false,
				autoHover: true,
				onSlideBefore: function(ele, oldIndex, newIndex) {
					$('.fl-node-<?php echo $id; ?> .fl-post-slider-navigation a').addClass('disabled');
					$('.fl-node-<?php echo $id; ?> .bx-controls .bx-pager-link').addClass('disabled');
				},
				onSlideAfter: function( ele, oldIndex, newIndex ) {
					$('.fl-node-<?php echo $id; ?> .fl-post-slider-navigation a').removeClass('disabled');
					$('.fl-node-<?php echo $id; ?> .bx-controls .bx-pager-link').removeClass('disabled');
				}
			}
		});

	});

})(jQuery);
