<?php 
/**
 * Plugin Name: Beaver Builder Video Lightbox
 * Description: A video lightbox module for Beaver Builder.
 * Version: 0.1.8
 * Author: Zach
 * Author URI: https://hipcreativeinc.com
*/

define( 'VIDEO_LIGHTBOX_DIR', plugin_dir_path( __FILE__ ) . 'module/' );
define( 'VIDEO_LIGHTBOX_URL', plugins_url( '/', __FILE__ ) . 'module/' );

add_action( 'init', function() {
	require_once( plugin_dir_path( __FILE__ ) . 'lib/YoutubeVideo.php' );
	
	if ( class_exists( 'FLBuilder' ) )
		require_once( VIDEO_LIGHTBOX_DIR . 'video-lightbox.php' );
} );
