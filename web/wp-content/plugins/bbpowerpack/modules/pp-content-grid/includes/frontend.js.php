
<?php
$space_desktop	= ( $settings->post_grid_count['desktop'] - 1 ) * $settings->post_spacing;
$space_tablet 	= ( $settings->post_grid_count['tablet'] - 1 ) * $settings->post_spacing;
$space_mobile 	= ( $settings->post_grid_count['mobile'] - 1 ) * $settings->post_spacing;
$speed          = !empty( $settings->transition_speed ) ? $settings->transition_speed * 1000 : '200';
$slide_speed    = ( isset( $settings->slides_speed ) && ! empty( $settings->slides_speed ) ) ? $settings->slides_speed * 1000 : 'false';
$page_arg	 	= is_front_page() ? 'page' : 'paged';
$paged 			= get_query_var( $page_arg, 1 );
?>

var ppcg_<?php echo $id; ?> = '';
var left_arrow_svg = '<svg aria-hidden="true" data-prefix="fal" data-icon="angle-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512" class="svg-inline--fa fa-angle-left fa-w-6 fa-2x"><path fill="currentColor" d="M25.1 247.5l117.8-116c4.7-4.7 12.3-4.7 17 0l7.1 7.1c4.7 4.7 4.7 12.3 0 17L64.7 256l102.2 100.4c4.7 4.7 4.7 12.3 0 17l-7.1 7.1c-4.7 4.7-12.3 4.7-17 0L25 264.5c-4.6-4.7-4.6-12.3.1-17z" class=""></path></svg>';
var right_arrow_svg = '<svg aria-hidden="true" data-prefix="fal" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512" class="svg-inline--fa fa-angle-right fa-w-6 fa-2x"><path fill="currentColor" d="M166.9 264.5l-117.8 116c-4.7 4.7-12.3 4.7-17 0l-7.1-7.1c-4.7-4.7-4.7-12.3 0-17L127.3 256 25.1 155.6c-4.7-4.7-4.7-12.3 0-17l7.1-7.1c4.7-4.7 12.3-4.7 17 0l117.8 116c4.6 4.7 4.6 12.3-.1 17z" class=""></path></svg>';

;(function($) {

	var PPContentGridOptions = {
		id: '<?php echo $id ?>',
		layout: '<?php echo $settings->layout; ?>',
		ajaxUrl: '<?php echo admin_url('admin-ajax.php'); ?>',
		perPage: '<?php echo $settings->posts_per_page; ?>',
		fields: <?php echo json_encode($settings); ?>,
		pagination: '<?php echo $settings->pagination; ?>',
		current_page: '<?php echo home_url($_SERVER['REQUEST_URI']); ?>',
		page: '<?php echo $paged; ?>',
		postSpacing: '<?php echo $settings->post_spacing; ?>',
		postColumns: {
			desktop: <?php echo $settings->post_grid_count['desktop']; ?>,
			tablet: <?php echo $settings->post_grid_count['tablet']; ?>,
			mobile: <?php echo $settings->post_grid_count['mobile']; ?>,
		},
		matchHeight: '<?php echo $settings->match_height; ?>',
		<?php echo (isset($settings->post_grid_filters_display) && 'yes' == $settings->post_grid_filters_display) ? 'filters: true' : 'filters: false'; ?>,
		<?php if ( isset( $settings->post_grid_filters ) && 'none' != $settings->post_grid_filters ) { ?>
        	filterTax: '<?php echo $settings->post_grid_filters; ?>',
        	filterType: '<?php echo isset( $settings->post_grid_filters_type ) ? $settings->post_grid_filters_type : 'static'; ?>',
		<?php } ?>
		<?php if ('grid' == $settings->layout && 'no' == $settings->match_height && 'style-9' != $settings->post_grid_style_select ) { ?>
		masonry: 'yes',
		<?php } ?>
		<?php if ( 'carousel' == $settings->layout ) { ?>
			carousel: {
				items: <?php echo $settings->post_grid_count['desktop']; ?>,
				responsive: {
					0: {
						items: <?php echo $settings->post_grid_count['mobile']; ?>,
					},
					768: {
						items: <?php echo $settings->post_grid_count['tablet']; ?>,
					},
					980: {
						items: <?php echo $settings->post_grid_count['desktop']; ?>,
					},
					1199: {
						items: <?php echo $settings->post_grid_count['desktop']; ?>,
					},
				},
	        <?php if( isset( $settings->slider_pagination ) && $settings->slider_pagination == 'no' ): ?>
		        dots: false,
		    <?php endif; ?>
	        <?php if( isset( $settings->auto_play ) ): ?>
		        <?php echo 'yes' == $settings->auto_play ? 'autoplay: true' : 'autoplay: false'; ?>,
		    <?php endif; ?>
		        autoplayTimeout: <?php echo $speed ?>,
		        autoplaySpeed: <?php echo $slide_speed ?>,
		        navSpeed: <?php echo $slide_speed ?>,
		        dotsSpeed: <?php echo $slide_speed ?>,
		    	<?php echo 'yes' == $settings->slider_navigation ? 'nav: true' : 'nav: false'; ?>,
		    	<?php echo ($settings->stop_on_hover == 'yes') ? 'autoplayHoverPause: true' : 'autoplayHoverPause: false'; ?>,
				<?php echo ($settings->lazy_load == 'yes') ? 'lazyLoad: true' : 'lazyLoad: false'; ?>,
				navText : [left_arrow_svg, right_arrow_svg],
			    responsiveRefreshRate : 200,
			    responsiveBaseWidth: window,
				loop: true
			}
		<?php } ?>
	};

	<?php if ( isset( $_GET['orderby'] ) && ! empty( $_GET['orderby'] ) ) { ?>
    PPContentGridOptions.orderby = '<?php echo (string)$_GET['orderby']; ?>';
    <?php } ?>

	ppcg_<?php echo $id; ?> = new PPContentGrid( PPContentGridOptions );
	
	// expandable row fix.
	var state = 0;
	$(document).on('pp_expandable_row_toggle', function(e, selector) {
		if ( selector.is('.pp-er-open') && state === 0 ) {
			ppcg_<?php echo $id; ?> = new PPContentGrid( PPContentGridOptions );
			state = 1;
		}
	});

})(jQuery);
