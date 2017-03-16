<?php

comments_template();

if ( ! comments_open() && ! get_comments_number() ) {
	$object = get_post_type_object( get_post_type() );
	echo '<div class="fl-builder-module-placeholder-message">';
	_ex( sprintf( 'Comments will not display for this %s.', $object->labels->singular_name ), 'post type label', 'fl-theme-builder' );
	echo '</div>';
}
