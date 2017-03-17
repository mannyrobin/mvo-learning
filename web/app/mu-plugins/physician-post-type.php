<?php

add_action( 'init', 'hip_med_register_physician' );
function hip_med_register_physician() {
	register_post_type( 'physician', [
		'labels'    => [
			'name'      => 'Physicians',
			'singular_name' => 'Physician',
			'all_items'     => 'All Physicians',
			'add_new'       => 'New Physicians',
			'add_new_item'  => 'Add New Physician'
		],
		'public'        => true,
		'has_archive'   => 'physicians',
		'supports'      => [
			'title',
			'editor',
			'thumbnail'
		]
	] );
}

