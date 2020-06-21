<?php
/**
 * Plugin Name: Hip Video Collection
 * Description: Organize videos hosted on youtube.
 * Version: 1.6.11
 * Author: Hip Creative, Inc
 * Author URI: http://hip.agency/
 */
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
	require __DIR__ . '/vendor/autoload.php';
}
	
require_once(__DIR__ . '/src/VideoCollection.php');
require_once(__DIR__ . '/src/Video.php');
require_once __DIR__ . '/src/VideoCollectionSettings.php';
require_once __DIR__ . '/src/VideoCollectionSettingsPage.php';
require_once __DIR__ . '/src/VideoCollectionSettingsAPI.php';
require_once __DIR__ . '/src/Background/AddPadding.php';
require_once(__DIR__ . '/gutenberg-blocks/video-from-collection/block.php');

define('HVC_VERSION', '1.6.11');
define('HVC_PATH', __DIR__);
define('HVC_URL', plugins_url(basename(HVC_PATH)));
add_image_size('pvc_preview', 640, 360, true);
add_image_size('pvc_preview@2x', 1280, 720, true);
add_action('plugins_loaded', 'hvc_load');
function hvc_load()
{
	$collection = new HipVideoCollection\VideoCollection();
	$settingsPage = new HipVideoCollection\SettingsPage($collection);
	if (function_exists('register_block_type')) {
		$gutenbergVideoBlock = new HipVideoCollection\VideoFromCollectionBlock();
	}
}
