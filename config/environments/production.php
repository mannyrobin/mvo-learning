<?php
/** Production */
ini_set('display_errors', 0);
define('WP_DEBUG_DISPLAY', false);
define('SCRIPT_DEBUG', false);
/** Disable all file modifications including updates and update notifications */
define('DISALLOW_FILE_MODS', true);

if (!empty(env('PANTHEON_ENVIRONMENT')) && php_sapi_name() != 'cli') {
  // Redirect to https://$primary_domain in the Live environment
  if (env('PANTHEON_ENVIRONMENT') === 'live') {
    /** Replace www.example.com with your registered domain name */
    $primary_domain = 'ministryvillageelc.org';
  }
  else {
    // Redirect to HTTPS on every Pantheon environment.
    $primary_domain = $_SERVER['HTTP_HOST'];
  }
  
  if ( $_SERVER['HTTP_HOST'] == 'refer.live-drhackel.pantheonsite.io' ) {
		header('HTTP/1.0 301 Moved Permanehtly');
		header('Location: https://' . $primary_domain . '/refer');
		exit();
	}

  if ($_SERVER['HTTP_HOST'] != $primary_domain
      || !isset($_SERVER['HTTP_USER_AGENT_HTTPS'])
      || $_SERVER['HTTP_USER_AGENT_HTTPS'] != 'ON' ) {

    # Name transaction "redirect" in New Relic for improved reporting (optional)
    if (extension_loaded('newrelic')) {
      newrelic_name_transaction("redirect");
    }

    header('HTTP/1.0 301 Moved Permanently');
    header('Location: https://'. $primary_domain . $_SERVER['REQUEST_URI']);
    exit();
  }
}
