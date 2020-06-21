<?php 
/**
 * Plugin Name: Google Sheets for WPForms
 * Description: Populate a Google Sheets spreadsheet from WPForms entries.
 * Author: Zach <zach@hipcreativeinc.com>
 * License: GPLv2+
 * Version: 0.3.0
 */

if ( ! defined( 'ABSPATH' ) )
	exit;

if ( file_exists( $dev_loader = __DIR__ . '/vendor/autoload.php' ) )
	require_once( $dev_loader );

function load_wpfgs()
{
	$GLOBALS['wpfgs'] = new \WPFGS\Plugin();
}
add_action( 'plugins_loaded', 'load_wpfgs' );
