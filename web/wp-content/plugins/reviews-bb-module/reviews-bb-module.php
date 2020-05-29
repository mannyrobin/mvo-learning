<?php
/**
 * Plugin Name: Review Us Beaver Builder Module
 * Description: Beaver Builder module for encouraging positive reviews while privately collecting negative reviews.
 * Version: 3.0.2
 * Author: Hip Creative, Inc
 * Author URI: https://hip.agency/
 */

if ( ! class_exists( 'FLBuilder' ) ) {
    exit;
}

define ( 'ReviewDir', plugin_dir_path( __FILE__ ) );
define ( 'ReviewURL', plugins_url( '/', __FILE__) );

function reviews_bb_module_load() {
    require_once ( 'reviews/reviews.php' );
}

add_action( 'init', 'reviews_bb_module_load' );

