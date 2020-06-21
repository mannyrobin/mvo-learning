<?php

namespace Hip\Conditions;

use Pimple\Container;

class Plugin extends Container
{
	public function __construct()
	{
		$this['settings'] = function ($container) {
			return new Settings();
		};
		
		$this['settings_page'] = function ($container) {
			return new SettingsPage();
		};
		
		$this['api'] = function ($container) {
			return new API();
		};

		$this['schema'] = function ($container) {
			return new SchemaOrgMarkup();
		};
	}
	
	public function run()
	{
		add_action('admin_menu', function () {
			$this['settings_page']->addOptionsPage();
		});
		
		add_action('rest_api_init', function () {
			$this['api']->addRoutes();
		});
		
		add_action('admin_enqueue_scripts', function () {
			$this['settings_page']->enqueueAssets();
		});

		add_action('wp_head', function () {
			global $post;
			$this['schema']->addMarkupToHeader($post);
		});

		add_action('init', [ $this, 'update' ], 5);
		add_action('init', [ $this, 'registerPostType' ], 10);
	}
	
	public function registerPostType()
	{
		$options = $this['settings']->getOptions();
		
		$labels = [
			'name'          => $options['condition_plural_label'],
			'singular_name'	=> $options['condition_singular_label']
		];
		
		register_post_type('conditions', [
			'labels'			=> $labels,
			'supports'			=> [ 'title', 'revisions' ],
			'public'			=> true,
			'has_archive'		=> $options['condition_slug'],
			'rewrite'			=> [ 'slug' => $options['condition_slug'] ],
			'hierarchical'	    => true,
			'supports'			=> [
				'title',
				'editor',
				'thumbnail',
				'page-attributes',
				'excerpt',
				'revisions'
			]
		]);
		
		register_taxonomy('conditions_category', [ 'conditions' ], [
			'label'             => $options['condition_cat_label'],
			'show_admin_column' => true,
			'hierarchical'      => true,
			'rewrite'           => [ 'slug' => $options['condition_cat_slug'] ]
		]);
	}

	public function update()
	{
		$options = $this['settings']->getOptions();
		$saved_version = get_option('hip_conditions_version') ? get_option('hip_conditions_version'): '1.1.2';
		if (version_compare($saved_version, '1.1.2', '<=')) {
			if ($options['condition_label']) {
				$options['condition_singular_label'] = $options['condition_label'];
				$options['condition_plural_label'] = $options['condition_label'] . 's';
				$this['settings']->saveOptions($options);
			}
		}
		update_option('hip_conditions_version', $this['version']);
	}
}
