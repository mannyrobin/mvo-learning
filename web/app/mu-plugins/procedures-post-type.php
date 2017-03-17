<?php

add_action( 'init', 'hip_med_register_procedure' );
function hip_med_register_procedure() {
	register_post_type( 'procedure', [
	'labels'    => [
	'name'      => 'Procedures',
	'singular_name' => 'Procedure',
	'all_items'     => 'All Procedures',
	'add_new'       => 'New Procedure',
	'add_new_item'  => 'Add New Procedure'
	],
	'public'        => true,
	'has_archive'   => 'procedures',
	'supports'      => [
	'title',
	'editor',
	'thumbnail'
	]
	] );
}
