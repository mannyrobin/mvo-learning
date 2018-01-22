<?php

/**
 * Enqueues child theme scripts and styles
 */
add_action('wp_enqueue_scripts', 'hip_child_scripts_and_styles');
function hip_child_scripts_and_styles()
{
	wp_enqueue_style('main', get_stylesheet_directory_uri() . '/dist/css/main.css');
}

/**
 * Adds an archive title field connection to BB
 *
 * Unlike the default "Archive Title" field connection, this one can be customized
 * with WordPress 'get_the_archive_title' filter. This is added to the child
 * theme rather than the parent so that it can be customized for each site.
 */
add_action('fl_page_data_add_properties', function () {
	FLPageData::add_archive_property('real_archive_title', [
		'label'		=> 'Real Archive Title',
		'group'		=> 'archive',
		'type'		=> 'string',
		'getter'	=> 'hip_display_archive_title'
	]);
});

function hip_display_archive_title()
{
	return get_the_archive_title();
}

add_filter('get_the_archive_title', function ($title) {
	if (is_home()) {
		$title = 'Our Blog';
	}
	
	if (is_search()) {
		$title = 'Results for: ' . get_search_query(false);
	}
	
	return $title;
});

add_action('after_footer', function () {
	do_shortcode('[hip_tabbar]');
});

/**
 * Show excerpts metabox in admin screen.
 *
 * No one likes hunting for the option to turn this on, and
 * sometimes team members forget where to find the option.
 */
add_filter('default_hidden_meta_boxes', 'show_hidden_meta_boxes', 10, 2);
function show_hidden_meta_boxes($hidden, $screen)
{
	if ('post' == $screen->base) {
		foreach ($hidden as $key => $value) {
			if ('postexcerpt' == $value) {
				unset($hidden[$key]);
				break;
			}
		}
	}
 
	return $hidden;
}

/* Settings css in child theme */

function child_theme_settings_styles(){
    $general_settings = General\Settings::getSettings();
    ob_start();
    ?>
    <style type="text/css">
        header .top-header.style-1 ul.menu li.top-menu-btn a{
            background-color: <?php echo $general_settings['secondary_color'];?>;
        }
        header .top-header.style-1 ul.menu li.top-menu-btn a:hover{
            background-color: #<?php echo (new Helpers\PHPColors\Color($general_settings['secondary_color']))->darken(5);?>;
        }
    </style>

    <?php
    return ob_get_flush();
}
add_action('wp_head', 'child_theme_settings_styles');