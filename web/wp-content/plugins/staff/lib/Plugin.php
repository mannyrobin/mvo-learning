<?php 

namespace HipStaff;
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

		add_filter( 'rwmb_meta_boxes', [$this, 'register_meta_box'] );

		add_action('init', [ $this, 'update' ], 5);
		add_action('init', [ $this, 'register_post_type' ], 10);
		add_action('init',[$this,'staff_bb_module']);
	}
	
	public function register_post_type()
	{
		$options = $this['settings']->getOptions();
		
		$labels = [
			'name'			=> $options['staff_plural_label'],
			'singular_name'	=> $options['staff_singular_label'],
			'add_new_item'  => 'Add New '.$options['staff_singular_label']
		];
		
		register_post_type( 'staff', [
			'labels'			=> $labels,
			'public'			=> true,
			'has_archive'		=> $options['staff_slug'],
			'rewrite'			=> [ 'slug' => $options['staff_slug'] ],
			'hierarchical'		=> true,
			'supports'			=> [
				'title',
				'editor',
				'thumbnail',
				'page-attributes',
				'excerpt',
				'revisions'
			]
		] );
		
		register_taxonomy( 'staff_category', [ 'staff' ], [
			'label'				=> $options['staff_cat_label'],
			'show_admin_column'	=> true,
			'hierarchical'		=> true,
			'rewrite'			=> [ 'slug' => $options['staff_cat_slug'] ]
		] );
	}

	public function register_meta_box( $meta_boxes )
	{
		$meta_boxes[] = [
			'title'			=> 'Details',
			'post_types'	=> 'staff',
			'context'		=> 'normal',
			'priority'		=> 'high',
			'fields'		=> [
				[
					'name'	=> 'Title',
					'id'	=> 'staff_title',
					'type'	=> 'text'
				],
				[
					'name'	=> 'Email',
					'id'	=> 'staff_email',
					'type'	=> 'text'
				],
				[
					'name'	=> 'Phone',
					'id'	=> 'staff_phone',
					'type'	=> 'text'
				]
			]
		];

		return $meta_boxes;
	}

	public function staff_bb_module(){
		if ( class_exists( 'FLBuilder' ) ) {
			require_once $this['dir'].'/staff-bb-module/staff-bb-module.php';
		}
	}

	public function update()
	{
		$options = $this['settings']->getOptions();
		$saved_version = get_option('hip_staff_version') ? get_option('hip_staff_version'): '1.1.2';
		if (version_compare($saved_version, '1.1.2', '<=')) {
			if ($options['staff_label']) {
				$options['staff_singular_label'] = $options['staff_label'];
				$options['staff_plural_label'] = $options['staff_label'] . 's';
				$this['settings']->saveOptions($options);
			}
		}
		update_option('hip_staff_version', $this['version']);
	}
}
