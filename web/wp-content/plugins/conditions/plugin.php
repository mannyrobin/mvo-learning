<?php
/**
 * Plugin Name: Hip Conditions CPT
 * Description: Everything needed to manage conditions for Hip client sites.
 * Version: 1.1.4
 * Author: Hip Creative
*/

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
	require __DIR__ . '/vendor/autoload.php';
}

$hipConditions = new Hip\Conditions\Plugin();
$hipConditions['version'] = '1.1.4';
$hipConditions['url'] = plugins_url('', __FILE__);
$hipConditions['dir'] = __DIR__;

add_action('plugins_loaded', function () use ($hipConditions) {
	$hipConditions->run();
});
