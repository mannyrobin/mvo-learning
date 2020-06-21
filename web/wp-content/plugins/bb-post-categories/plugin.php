<?php
/**
 * Plugin Name: BB Posts Categories Module
 * Description: Post categories module for beaver builder. List post categories with custom filtering option.
 * Version: 1.0.1
 * Author: Hip agency
 * Author URI: http://hip.agency
 */

/*
 * define module directory and url
 */
define('HIP_POST_CATEGORIES_DIR', plugin_dir_path(__FILE__));
define('HIP_POST_CATEGORIES_URL', plugins_url('/', __FILE__));
/*
 * register related posts module for beaver builder
 */
function hip_post_categories_module()
{
	if (class_exists('FLBuilder')) {
		require_once 'hip-post-categories-module/HIPPostCategoriesModule.php';
	}
}
add_action('init', 'hip_post_categories_module');