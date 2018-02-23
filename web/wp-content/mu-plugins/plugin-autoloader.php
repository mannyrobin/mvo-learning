<?php
/** Set certain plugins to always be active on live, staging, and dev. Set other plugins to never be active on certain environments. **/

require_once(ABSPATH . 'wp-admin/includes/plugin.php');

if (is_blog_installed() && ! wp_installing() && function_exists('is_plugin_active')) {
	$active_prod = ["bb-plugin/fl-builder.php", "redirection/redirection.php"];
	$active_staging = ["bb-plugin/fl-builder.php", "redirection/redirection.php"];
	$active_dev = [];

	$disabled_dev = [];
	$disabled_staging = ["mergebot/mergebot.php"];

	if (WP_ENV == 'production') {
		foreach ($active_prod as $plugin) {
			if (! is_plugin_active($plugin)) {
				activate_plugin($plugin);
			}
		}
	} elseif (WP_ENV == 'staging') {
		foreach ($active_staging as $plugin) {
			if (!is_plugin_active($plugin)) {
				activate_plugin($plugin);
			}
		}
		foreach ($disabled_staging as $plugin) {
			if (is_plugin_active($plugin)) {
				deactivate_plugins($plugin);
			}
		}
	} elseif (WP_ENV == 'development') {
		foreach ($active_dev as $plugin) {
			if (!is_plugin_active($plugin)) {
				activate_plugin($plugin);
			}
		}
		foreach ($disabled_dev as $plugin) {
			if (is_plugin_active($plugin)) {
				deactivate_plugins($plugin);
			}
		}
	}
}
