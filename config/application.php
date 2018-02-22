<?php

/** @var string Directory containing all of the site's files */
$root_dir = dirname(__DIR__);

/** @var string Document Root */
$webroot_dir = $root_dir . '/web';

/**
 * Expose global env() function from oscarotero/env
 */
Env::init();

/**
 * Use Dotenv to set required environment variables and load .env file in root
 */
$dotenv = new Dotenv\Dotenv($root_dir);
if (file_exists($root_dir . '/.env')) {
	$dotenv->load();
	$dotenv->required(['DB_NAME', 'DB_USER', 'DB_PASSWORD', 'WP_HOME', 'WP_SITEURL']);
}

/**
 * Set up our global environment constant and load its config first
 */
if ($_ENV['PANTHEON_ENVIRONMENT']) {
	if ($_ENV['PANTHEON_ENVIRONMENT'] === 'live') {
		define('WP_ENV', 'production');
	} elseif ($_ENV['PANTHEON_ENVIRONMENT'] === 'test') {
		define('WP_ENV', 'staging');
	} else {
		define('WP_ENV', 'development');
	}
} else {
	define('WP_ENV', $_ENV['WP_ENV'] ?: 'development');
}


$env_config = __DIR__ . '/environments/' . WP_ENV . '.php';

if (file_exists($env_config)) {
	require_once $env_config;
}

/**
 * URLs
 */
/** A couple extra tweaks to help things run well on Pantheon. **/
if (isset($_ENV['WP_HOME']) && isset($_ENV['WP_SITEURL'])) {
	define('WP_HOME', $_ENV['WP_HOME']);
	define('WP_SITEURL', $_ENV['WP_SITEURL']);
} elseif (isset($_SERVER['HTTP_HOST'])) {
		// HTTP is still the default scheme for now.
		$scheme = 'http';
		// If we have detected that the end use is HTTPS, make sure we pass that
		// through here, so <img> tags and the like don't generate mixed-mode
		// content warnings.
	if (isset($_SERVER['HTTP_USER_AGENT_HTTPS']) && $_SERVER['HTTP_USER_AGENT_HTTPS'] == 'ON') {
			$scheme = 'https';
	}
		define('WP_HOME', $scheme . '://' . $_SERVER['HTTP_HOST']);
		define('WP_SITEURL', $scheme . '://' . $_SERVER['HTTP_HOST'] . '/wp');
}

/**
 * Custom Content Directory
 */
define('CONTENT_DIR', '/wp-content');
define('WP_CONTENT_DIR', $webroot_dir . CONTENT_DIR);
define('WP_CONTENT_URL', WP_HOME . CONTENT_DIR);

/**
 * DB settings
 */

$host_string = $_ENV['DB_HOST'] ?: 'localhost';
if ($_ENV['DB_PORT']) {
	$host_string .= ':' . $_ENV['DB_PORT'];
}
define('DB_NAME', $_ENV['DB_NAME']);
define('DB_USER', $_ENV['DB_USER']);
define('DB_PASSWORD', $_ENV['DB_PASSWORD']);
define('DB_HOST', $host_string);
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');
$table_prefix = $_ENV['DB_PREFIX'] ?: 'wp_';

/**
 * Authentication Unique Keys and Salts
 */
define('AUTH_KEY', $_ENV['AUTH_KEY']);
define('SECURE_AUTH_KEY', $_ENV['SECURE_AUTH_KEY']);
define('LOGGED_IN_KEY', $_ENV['LOGGED_IN_KEY']);
define('NONCE_KEY', $_ENV['NONCE_KEY']);
define('AUTH_SALT', $_ENV['AUTH_SALT']);
define('SECURE_AUTH_SALT', $_ENV['SECURE_AUTH_SALT']);
define('LOGGED_IN_SALT', $_ENV['LOGGED_IN_SALT']);
define('NONCE_SALT', $_ENV['NONCE_SALT']);

/**
 * Custom Settings
 */
define('AUTOMATIC_UPDATER_DISABLED', true);
define('DISABLE_WP_CRON', $_ENV['DISABLE_WP_CRON'] ?: false);
define('DISALLOW_FILE_EDIT', true);
	
// Force the use of a safe temp directory when in a container
if (defined('PANTHEON_BINDING')) :
		define('WP_TEMP_DIR', sprintf('/srv/bindings/%s/tmp', PANTHEON_BINDING));
endif;


/**
 * Bootstrap WordPress
 */
if (!defined('ABSPATH')) {
	define('ABSPATH', $webroot_dir . '/wp/');
}
