<?php

/*
 * Theme Version 
 *
 * Added as query strings to stylesheets and scripts to bust  browser cache.
 */

define('THEME_VERSION', '4.4.9');

/**
 * Include necessary files.
 */
require_once __DIR__ . '/lib/CSSHandler.php';
require_once __DIR__ . '/lib/Breadcrumbs.php';
require_once __DIR__ . '/lib/hip-settings/hip-settings.php';

$css_handler = new CSSHandler(
	get_template_directory() . '/dist/css',
	get_template_directory_uri() . '/dist/css',
	THEME_VERSION
);

function hip_bb_load_stylesheets()
{
	global $css_handler;
	
	$css_handler->setTemplateStyles();
	
	add_action('inline_css', [ $css_handler, 'getInlineCSS' ]);
	add_action('deferred_css', [ $css_handler, 'getDeferredCSS' ]);
}

add_action('wp', 'hip_bb_load_stylesheets');

/**
 * Theme Setup
 */
function hip_bb_setup()
{
	require_once(get_template_directory() . '/lib/shortcodes.php');
	require_once(get_template_directory() . '/lib/widgets.php');

	add_theme_support('post-thumbnails');
	add_theme_support('title-tag');
	add_theme_support('fl-theme-builder-headers');
	add_theme_support('fl-theme-builder-footers');
	add_theme_support('fl-theme-builder-parts');
	
	add_filter('widget_text', 'do_shortcode');
	register_nav_menus([
		'top'			=> 'Secondary header menu',
		'main'		=> 'Primary menu',
		'mobile'	=> 'Mobile Dropdown Menu',
		'hero'		=> 'Hero Dropdown Menu'
	]);
	
	if (class_exists('FLBuilder')) {
		FLBuilder::register_templates(get_template_directory() . '/templates/templates.dat');
		FLBuilder::register_templates(get_template_directory() . '/templates/hero1.dat');
		FLBuilder::register_templates(get_template_directory() . '/templates/search.dat');
		FLBuilder::register_templates(get_template_directory() . '/templates/lp.dat');
	}
}

add_action('after_setup_theme', 'hip_bb_setup');

function hip_bb_no_index()
{
	if (has_term('thank-you', 'lp-category')) {
		echo '<meta name="robots" content="noindex, nofollow">';
	}
}
add_action('wp_head', 'hip_bb_no_index');
/**
 * Add support for beaver themer header and footer.
 */
function hip_bb_header_footer_support()
{
	add_theme_support('fl-theme-builder-headers');
	add_theme_support('fl-theme-builder-footers');
	add_theme_support('fl-theme-builder-parts');
}
add_action('after_setup_theme', 'hip_bb_header_footer_support');

/**
 * Render BB Themer Header and Footer
 */
function hip_bb_header_footer_render()
{
	if (! class_exists('FLThemeBuilderLayoutData')) {
		return;
	}
	
	$header_ids = FLThemeBuilderLayoutData::get_current_page_header_ids();
	
	if (!empty($header_ids)) {
		add_action('hip_bb_header', 'FLThemeBuilderLayoutRenderer::render_header');
	}
	
	$footer_ids = FLThemeBuilderLayoutData::get_current_page_footer_ids();
	
	if (!empty($footer_ids)) {
		add_action('hip_bb_footer', 'FLThemeBuilderLayoutRenderer::render_footer');
	}
}
add_action('wp', 'hip_bb_header_footer_render');

/**
 * Render BB Themer Hooks for theme parts
 */
function hip_bb_register_part_hooks()
{
	return [
		[
			'label'		=> 'Header',
			'hooks'		=> [
				'before_header'	=> 'Before Header',
				'after_header'	=> 'After Header'
			]
		],
		[
			'label'		=> 'Content',
			'hooks'		=> [
				'hip_bb_banner'					=> 'Banner',
				'hip_bb_breadcrumbs'			=> 'Breadcrumbs',
				'hip_bb_sidebar'				=> 'Sidebar',
				'hip_bb_after_content'	=> 'After Content',
			]
		],
		[
			'label'		=> 'Footer',
			'hooks'		=> [
				'before_footer'	=> 'Before Footer',
				'after_footer'	=> 'After Footer'
			]
		]
	];
}
add_filter('fl_theme_builder_part_hooks', 'hip_bb_register_part_hooks');

/*
* Include theme styles and scripts
*/
function enqueue_custom_scripts()
{

	if (is_blog()) {
		wp_enqueue_style('blog-style', get_template_directory_uri() . '/dist/css/blog.css', [], THEME_VERSION);
	}
	
	if (is_search()) {
			wp_enqueue_style('search-style', get_template_directory_uri() . '/dist/css/search.css', [], THEME_VERSION);
	}
	/* enqueue font awesome if not exists*/
    global $wp_styles;
    $srcs = array_map('basename', (array) wp_list_pluck($wp_styles->registered, 'src') );
    if(!in_array('font-awesome.min.css',$srcs) && !in_array('font-awesome.css',$srcs)){
        wp_enqueue_style('font-awesome','https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',[],THEME_VERSION);
    }else{
        $handler = array_search('font-awesome.min.css', $srcs) ? array_search('font-awesome.min.css', $srcs) : array_search('font-awesome.css', $srcs);
        if(!wp_style_is($handler,'enqueued')){
            wp_enqueue_style($handler);
        };
    }

}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');


/*
* Utility function for detect blog pages
* source: https://gist.github.com/wesbos/1189639
*/
function is_blog()
{
	global  $post;
	$post_type = get_post_type($post);
	return ( ( (is_archive()) || (is_author()) || (is_category()) || (is_home()) || (is_single()) || (is_tag())) && ( $post_type == 'post')  ) ? true : false ;
}

class Walker_Nav_Menu_Dropdown extends Walker_Nav_Menu
{
	function start_lvl(&$output, $depth = 0, $args = [])
	{
		$indent = str_repeat("\t", $depth); // don't output children opening tag (`<ul>`)
	}
	function end_lvl(&$output, $depth = 0, $args = [])
	{
		$indent = str_repeat("\t", $depth); // don't output children closing tag
	}
	/**
	 * Start the element output.
	 *
	 * @param  string $output Passed by reference. Used to append additional content.
	 * @param  object $item   Menu item data object.
	 * @param  int $depth     Depth of menu item. May be used for padding.
	 * @param  array $args    Additional strings.
	 * @return void
	 */
	function start_el(&$output, $item, $depth = 0, $args = [], $id = 0)
	{
		if ($depth == 0 && in_array('menu-item-has-children', $item->classes)) {
			$output .= '<optgroup label="' . $item->title . '">';
		} else {
			$url = '#' !== $item->url ? $item->url : '';
			$output .= '<option value="' . $url . '">' . $item->title;
		}
	}
	function end_el(&$output, $item, $depth = 0, $args = 0)
	{
		if ($depth == 0) {
			$output .= "</optgroup>\n";
		} else {
			$output .= "</option>\n"; // replace closing </li> with the option tag
		}
	}
}

function hip_remove_hentry_class($classes)
{
	$classes = array_diff($classes, array( 'hentry' ));
	$classes[] = 'entry';
	return $classes;
}
add_filter('post_class', 'hip_remove_hentry_class');
