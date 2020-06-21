<?php

namespace Hip\Services;

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

		$this['featured'] = function ($container) {
			return new FeaturedPostMeta();
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

		add_action('add_meta_boxes', function () {
			$this['featured']->cpt_featuredpost_metabox();
		});

        add_action('save_post', function ($post_id, $post, $update) {
            if ( $post->post_type != 'services' ) {
                return;
            }

			$this['featured']->cpt_featuredpost_metabox_save($post_id);
		}, 10, 3);

		add_action('init', [ $this, 'update' ], 5);
		add_action('init', [ $this, 'register_post_type' ], 10);
	}

	public function register_post_type()
	{
		$options = $this['settings']->getOptions();
		$labels = [
			'name'          => $options['service_plural_label'] ?  $options['service_plural_label'] : 'Services',
			'singular_name'	=> $options['service_singular_label'] ? $options['service_singular_label'] : 'Service'
		];

		register_post_type('services', [
			'labels'			=> $labels,
			'public'			=> true,
			'has_archive'		=> $options['service_slug'] ? $options['service_slug'] : 'services',
			'rewrite'			=> [ 'slug' => $options['service_slug'] ? $options['service_slug'] : 'services' ],
			'supports'			=> [
				'title',
				'editor',
				'thumbnail',
				'page-attributes',
				'excerpt',
				'revisions'
			]
		]);

		register_taxonomy('services_category', [ 'services' ], [
			'label'             => $options['service_cat_label'] ?  $options['service_cat_label'] : 'Services Categories',
			'show_admin_column' => true,
			'hierarchical'      => true,
			'rewrite'           => [ 'slug' => $options['service_cat_slug'] ] ?  $options['service_cat_slug'] : 'services-categories'
		]);
	}


	public function update()
	{
		$options = $this['settings']->getOptions();
		$saved_version = get_option('hip_services_version') ? get_option('hip_services_version'): '1.0.0';
		if (version_compare($saved_version, '1.0.0', '<=')) {
			if ($options['service_label']) {
				$options['service_singular_label'] = $options['service_label'];
				$options['service_plural_label'] = $options['service_label'] . 's';
				$this['settings']->saveOptions($options);
			}
		}
		update_option('hip_services_version', $this['version']);
	}
}
