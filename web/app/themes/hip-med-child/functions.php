<?php 

/**
 * Enqueues child theme scripts and styles
 */
add_action( 'wp_enqueue_scripts', 'hip_child_scripts_and_styles' );
function hip_child_scripts_and_styles() {
	wp_enqueue_style( 'main', get_stylesheet_directory_uri() . '/dist/css/main.css' );
}

/**
 * Adds an archive title field connection to BB
 * 
 * Unlike the default "Archive Title" field connection, this one can be customized
 * with WordPress 'get_the_archive_title' filter. This is added to the child 
 * theme rather than the parent so that it can be customized for each site.
 */
add_action( 'fl_page_data_add_properties', function() {
	FLPageData::add_archive_property( 'real_archive_title', [
		'label'		=> 'Real Archive Title',
		'group'		=> 'archive',
		'type'		=> 'string',
		'getter'	=> 'hip_display_archive_title'
	] );
} );

function hip_display_archive_title() {
	return get_the_archive_title();
}

add_filter( 'get_the_archive_title', function( $title ) {
	if ( is_home() )
		$title = 'Our Blog';
	
	if ( is_search() )
		$title = 'Results for: ' . get_search_query(false);
	
	return $title;
});

add_action( 'after_footer', function() {
	do_shortcode( '[hip_tabbar]' );
} );
