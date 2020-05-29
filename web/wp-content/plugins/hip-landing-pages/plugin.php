<?php 
/**
 * Plugin Name: Hip Landing Pages CPT
 * Description: Everything needed to manage landing pages for Hip client sites.
 * Version: 1.0.3
 * Author: Hip Creative
*/

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) )
	require __DIR__ . '/vendor/autoload.php';

$hipLP = new Hip\LP\Plugin();
$hipLP['version'] = '1.0.3';
$hipLP['url'] = plugins_url( '', __FILE__ );
$hipLP['dir'] = __DIR__;

add_action( 'init', function() use ( $hipLP ) {
	$hipLP->run();
} );
	
