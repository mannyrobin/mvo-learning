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
if (env('PANTHEON_ENVIRONMENT')) {
    if (env('PANTHEON_ENVIRONMENT') === 'live') {
        define('WP_ENV', 'production');
    } elseif (env('PANTHEON_ENVIRONMENT') === 'test') {
        define('WP_ENV', 'staging');
    } else {
        define('WP_ENV', 'development');
    }
} else {
    define('WP_ENV', env('WP_ENV') ?: 'development');
}


$env_config = __DIR__ . '/environments/' . WP_ENV . '.php';

if (file_exists($env_config)) {
    require_once $env_config;
}

/**
 * URLs
 */
/** A couple extra tweaks to help things run well on Pantheon. **/
if (!empty(env('WP_HOME')) && !empty(env('WP_SITEURL'))) {
    define('WP_HOME', env('WP_HOME'));
	define('WP_SITEURL', env('WP_SITEURL'));
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
define('WPMDB_LICENCE', '36b68ad8-fe9c-4fff-ae80-e3082798399e');
define('WPFORMS_LICENSE_KEY', '5bb6670118011a86a86ee3f58c85847e' );
define('FL_LICENSE_KEY', '7a62702e706176726976676e72657063767540617667666877' );

/**
 * DB settings
 */

$host_string = env('DB_HOST') ?: 'localhost';
if (env('DB_PORT')) {
    $host_string .= ':' . env('DB_PORT');
}
define('DB_NAME', env('DB_NAME'));
define('DB_USER', env('DB_USER'));
define('DB_PASSWORD', env('DB_PASSWORD'));
define('DB_HOST', $host_string);
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');
$table_prefix = env('DB_PREFIX') ?: 'wp_';

/**
 * Authentication Unique Keys and Salts
 */
define('AUTH_KEY', env('AUTH_KEY'));
define('SECURE_AUTH_KEY', env('SECURE_AUTH_KEY'));
define('LOGGED_IN_KEY', env('LOGGED_IN_KEY'));
define('NONCE_KEY', env('NONCE_KEY'));
define('AUTH_SALT', env('AUTH_SALT'));
define('SECURE_AUTH_SALT', env('SECURE_AUTH_SALT'));
define('LOGGED_IN_SALT', env('LOGGED_IN_SALT'));
define('NONCE_SALT', env('NONCE_SALT'));

/**
 * Custom Settings
 */
define('AUTOMATIC_UPDATER_DISABLED', true);
define('DISABLE_WP_CRON', env('DISABLE_WP_CRON') ?: false);
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
