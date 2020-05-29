<?php

/**
 * Plugin Name: Hip Services CPT
 * Description: Add Services post type, related post meta and Beaver Builder module to WordPress site.
 * Version: 1.1.1
 * Author: Hip Creative
 */

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
	require __DIR__ . '/vendor/autoload.php';
}
$hipServices = new Hip\Services\Plugin();
$hipServices['version'] = '1.1.1';
$hipServices['url'] = plugins_url('', __FILE__);
$hipServices['dir'] = plugin_dir_path(__FILE__);

add_action('plugins_loaded', function () use ($hipServices) {
	$hipServices->run();
});

add_action('init', function () use ($hipServices) {
	if (class_exists('FLBuilder')) {
		require_once 'featured-service-module/featured-service-module.php';
	}
});
