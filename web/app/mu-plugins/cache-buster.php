<?php

namespace HipMedSite;

class CacheBuster
{
	public static function init()
	{
		add_action('upgrader_process_complete', array( __class__, 'clear_caches' ));
		add_action('fl_builder_after_save_layout', array( __class__, 'clear_caches' ));
		add_action('fl_builder_after_save_user_template', array( __class__, 'clear_caches' ));
		add_action('fl_builder_cache_cleared', array( __class__, 'clear_caches' ));
		add_action('template_redirect', array( __class__, 'donotcache' ));
	}
	/**
	 * Clear the various cache plugins.
	 */
	public static function clearCaches()
	{
		//rocket cache
		if (function_exists('rocket_clean_domain')) {
			rocket_clean_domain();
		}
		// wp-super-cache
		if (function_exists('wp_cache_clear_cache')) {
			wp_cache_clear_cache();
		}
		// WPEngine
		if (class_exists('WpeCommon')) {
			WpeCommon::purge_memcached();
			WpeCommon::clear_maxcdn_cache();
			WpeCommon::purge_varnish_cache();
		}
		// w3 total crash
		if (function_exists('w3tc_pgcache_flush')) {
			w3tc_pgcache_flush();
		}
		// siteground
		if (function_exists('sg_cachepress_purge_cache')) {
			sg_cachepress_purge_cache();
		}
		
		// Nginx Cache
		if (class_exists('NginxCache')) {
			$nginxCache = new NginxCache();
			$nginxCache->purge_zone_once();
		}
		error_log('Cleared Caches');
	}
	/**
	 * Set DONOTCACHEPAGE if builder is active.
	 */
	public static function donotcache()
	{
		if (! defined('DONOTCACHEPAGE')
			&& class_exists('FLBuilderModel')
			&& \FLBuilderModel::is_builder_active() ) {
				define('DONOTCACHEPAGE', true);
		}
	}
}

CacheBuster::init();
