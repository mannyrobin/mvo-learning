<?php
/**
 * Plugin Name: Google Analytics for WPForms
 * Description: Track form events with Google Analytics
 * Author:      ydlr
 * Version:     0.1.2
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 * GPL2
 */

if (! defined('ABSPATH')) {
    exit;
}

if (file_exists($autoloader = __DIR__ . '/vendor/autoload.php')) {
    require_once($autoloader);
}

define('GA_WPFORMS_VERSION', '0.1.1');
define('GA_WPFORMS_URL', plugin_dir_url(__FILE__));
define('GA_WPFORMS_DIR', plugin_dir_path(__FILE__));

add_action('wpforms_loaded', 'ga_wpforms_load');
function ga_wpforms_load()
{
    require_once(GA_WPFORMS_DIR . '/src/provider.php');
    $plugin = new GA_WPForms();
}
