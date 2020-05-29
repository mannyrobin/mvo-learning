<?php 

namespace Hip\LP;
use Pimple\Container;

class Plugin extends Container
{
	public function __construct()
	{
		$this['settings'] = function( $container ) {
			return new Settings();
		};
		
		$this['settings_page'] = function( $container ) {
			return new SettingsPage();
		};
		
		$this['api'] = function( $container ) {
			return new API();
		};
	}
	
	public function run()
	{
		add_action( 'admin_menu', function() {
			$this['settings_page']->addOptionsPage();
		} );
		
		add_action( 'rest_api_init', function() {
			$this['api']->addRoutes();
		} );
		
		add_action( 'admin_enqueue_scripts', function() {
			$this['settings_page']->enqueueAssets();
		} );
		
		$this->register_post_type();
	}
	
	public function register_post_type()
	{
		$options = $this['settings']->getOptions();
		
		$labels = [
			'name'          => $options['lp_label'] . 's',
			'singular_name'	=> $options['lp_label']
		];
		
		register_post_type( 'lp', [
			'labels'	=> $labels,
			'supports'	=> [ 'title', 'revisions' ],
			'public'	=> true,
			'has_archive'	=> $options['lp_slug'],
			'rewrite'	=> [ 'slug' => $options['lp_slug'] ],
			'hierarchical'	=> true,
			'show_in_rest' => true,
			'supports'	=> [
				'title',
				'editor',
				'thumbnail',
				'page-attributes',
				'excerpt',
				'revisions'
			]
		] );
		
		register_taxonomy( 'lp_categories', [ 'lp' ], [
			'label'             => $options['lp_cat_label'],
			'show_admin_column' => true,
			'hierarchical'      => true,
			'rewrite'           => [ 'slug' => $options['lp_cat_slug'] ]
		] );
		
		flush_rewrite_rules();
	}
}
