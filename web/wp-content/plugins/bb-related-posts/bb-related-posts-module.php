<?php
/**
 * Plugin Name: BB Related Posts Module
 * Description: Related Posts Module for the Beaver Builder Plugin. Pulls the related posts based on category or selected posts.
 * Version: 1.0.4
 * Author: Rahat
 */

/*
 * define module directory and url
 */
define('RELATED_POSTS_DIR', plugin_dir_path(__FILE__));
define('RELATED_POSTS_URL', plugins_url('/', __FILE__));
/*
 * register related posts module for beaver builder
 */
function bb_related_posts_module()
{
    if (class_exists('FLBuilder')) {
        require_once 'related-posts-module/related-posts-module.php';
    }
}
add_action('init', 'bb_related_posts_module');
