<?php

add_action( 'init', 'hip_med_register_condition' );
function hip_med_register_condition() {
	register_post_type( 'condition', [
	'labels'    => [
	'name'      => 'Conditions',
	'singular_name' => 'Condition',
	'all_items'     => 'All Conditions',
	'add_new'       => 'New Condition',
	'add_new_item'  => 'Add New Condition'
	],
	'public'        => true,
	'has_archive'   => 'conditions',
	'supports'      => [
	'title',
	'editor',
	'thumbnail'
	]
	] );
}
