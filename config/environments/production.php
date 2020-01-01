<?php
/** Production */
ini_set('display_errors', 0);
define('WP_DEBUG_DISPLAY', false);
define('SCRIPT_DEBUG', false);
/** Disable all file modifications including updates and update notifications */
define('DISALLOW_FILE_MODS', true);


if (!empty(env('PANTHEON_ENVIRONMENT')) && php_sapi_name() != 'cli') {
	if (env('PANTHEON_ENVIRONMENT') === 'live') {
		$primary_domain = 'ministryvillageelc.org';
	} else {
		$primary_domain = $_SERVER['HTTP_HOST'];
	}

	if ($_SERVER['HTTP_HOST'] != $primary_domain) {
		header('HTTP/1.0 301 Moved Permanently');
		header('Location: https://' . $primary_domain . $_SERVER['REQUEST_URI']);
		exit();
	}
}