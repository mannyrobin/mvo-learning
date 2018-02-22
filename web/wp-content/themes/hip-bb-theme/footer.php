<?php
	
	do_action('before_footer');
	do_action('hip_bb_footer');
	do_action('after_footer');
	do_action('deferred_css');
	
	wp_footer();

?>
	<script src="<?php echo get_template_directory_uri() . '/dist/js/parent.js' ?>" async></script>
	</body>
</html>
