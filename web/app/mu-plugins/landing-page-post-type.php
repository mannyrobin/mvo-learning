<?php

add_action( 'init', 'hip_med_register_lp' );
function hip_med_register_lp() {
	register_post_type( 'lp', [
	'labels'    => [
	'name'      => 'Landing Pages',
	'singular_name' => 'Landing Page',
	'all_items'     => 'All Landing Pages',
	'add_new'       => 'New Landing Page',
	'add_new_item'  => 'Add New Landing Page'
	],
	'public'        => true,
	'has_archive'   => 'lp',
	'supports'      => [
	'title',
	'editor',
	'thumbnail'
	]
	] );
	
	register_taxonomy( 'lp-category', ['lp'], [
		'label'     => 'LP Categories',
		'show_admin_column' => true 
	] );
}

