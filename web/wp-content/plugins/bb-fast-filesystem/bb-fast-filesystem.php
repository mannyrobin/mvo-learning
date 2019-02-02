<?php
/**
 * Plugin Name: Beaver Builder Faster Filesystem
 * Description: Made beaver builder work faster
 * Version: 0.0.1
 * Author: Hip agency
 * Author URI: http://hip.agency
 */

add_action( 'plugins_loaded', function() {
		include 'filesystem.php';
		add_filter( 'fl_filesystem_instance', function() {
			return new Over_FL_Filesystem;
			}
		);
	}
);
