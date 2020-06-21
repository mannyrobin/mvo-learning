<?php 
/**
 * Plugin Name: Hip Staff CPT
 * Description: Everything needed to manage staff members for Hip client sites.
 * Version: 1.2.0
 * Author: Hip Creative
*/

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) )
	require __DIR__ . '/vendor/autoload.php';

$hipStaff = new HipStaff\Plugin();
$hipStaff['version'] = '1.2.0';
$hipStaff['url'] = plugins_url( '', __FILE__ );
$hipStaff['dir'] = __DIR__;

add_action( 'plugins_loaded', function() use ( $hipStaff ) {
	$hipStaff->run();
});
