<?php
/*
Plugin Name: Hip Calls to Action
Description: Simple, flexible, Calls-to-Action for Hip Marketing Sites.
Author: Hip Creative
Version: 0.4.2
*/

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) )
    require __DIR__ . '/vendor/autoload.php';

function hipcta_init()
{
    $app = new HipCTA\Plugin();
    $app->run();
}
add_action( 'plugins_loaded', 'hipcta_init' );

add_action( 'init', function() {
	if ( class_exists( 'FLBuilder' ) ) {
		require __DIR__ . '/bb-module.php';
	}
} );
