<?php

namespace HipCTA;
use Pimple\Container;

class Plugin extends Container
{
	/* Post Type */
    public $post_type = 'hipcta_cta';

	public function __construct() 
	{
		$this['slug'] = 'hipcta';
		$this['version'] = '0.4.2';
		
		$this['plugin_dir'] = dirname( __DIR__ );
		$this['plugin_url'] = plugins_url( '', dirname( __FILE__ ) );
		
		$this['template_vars'] = [];
		
		$this['twig'] = function( $container ) {
			$loader = new \Twig_Loader_Filesystem( $this['plugin_dir'] . '/templates' );
			return new \Twig_Environment( $loader );
		};
		
		$this->extend( 'twig', function( $twig, $container ) {
			$escaper = new \Twig_Extension_Escaper( 'html' );
			$twig->addExtension( $escaper );
			
			return $twig;
		} );
		
		$this['image_cta'] = function( $container ) {
			return new CTA\ImageCTA($container);
		};
		
		$this['image_cta_metabox'] = function( $container ) {
			return new MetaBoxes\ImageCTAMetaBox( $container['image_cta'] );
		};
		
		$this['post_flyout_metabox'] = function( $container ) {
			return new MetaBoxes\PostFlyoutMetaBox( $container );
		};
		
		$this['post_flyout'] = function( $container ) {
			return new PostFlyout( $container );
		};
		
		$this['shortcode_button'] = function( $container ) {
			return new ShortcodeButton( $container );
		};
		$this['all_cta'] = function ($container){
			return $this->all_cta();
		};
		$this->settings_page();
	}
	
	public function run()
	{
		add_action( 'init', [ $this, 'register_post_type' ] );
		add_action( 'add_meta_boxes', [ $this, 'add_meta_boxes' ] );
		add_action( 'admin_enqueue_scripts', [$this, 'admin_scripts_and_styles'] );
		add_action( 'wp_enqueue_scripts', [$this, 'enqueue_scripts_and_styles'] );
		add_action( 'admin_init', [ $this, 'update_plugin' ] );
		add_action( 'save_post', function( $post_id ) {
			if ( get_post_type() === 'hipcta_cta' ) {
				$this['image_cta']->set_id( $post_id );
				$this['image_cta_metabox']->update_post_meta( $_POST );
			}
			$this['post_flyout_metabox']->update_post_meta( $_POST );
		} );
		
		add_action( 'wp_ajax_flyout_admin', function() {
			$this['post_flyout_metabox']->get_cta_preview_ajax( $_POST );
		} );
		add_action( 'wp_footer', function() {
			if ( is_home() && get_option('page_for_posts') ) {
				$id = get_option('page_for_posts');
			} else {
				$id = get_the_ID();
			}
			$this['post_flyout']->set_post_id( $id );
			$this['post_flyout']->render();
		} );
		
		add_shortcode( 'hip-cta', function( $atts ) {
			$this['image_cta']->set_id( $atts['id'] );
			return $this['image_cta']->render();
		} );
		
		if ( is_admin() ) {
			$this['shortcode_button'];
		}

	}
	
	public function register_post_type()
	{
		$labels = [
			'name'          => __( 'CTAs', $this['slug'] ),
			'singular_name' => __( 'Call-to-Action', $this['slug'] ),
			'all_items'     => __( 'All CTAs', $this['slug'] ),
			'add_new_item'  => __( 'Add New CTA', $this['slug'] ),
			'new_item'      => __( 'New Call-to-Action', $this['slug'] ),
			'edit_item'     => __( 'Edit Call-to-Action', $this['slug'] )
		];
		
		$args = [
			'label'         => __( 'CTAs', $this['slug'] ),
			'description'   => __( 'Simple, flexible, Calls-to-Action', $this['slug'] ),
			'labels'        => $labels,
			'supports'      => [ 'title', 'revisions' ],
			'public'        => true,
			'show_ui'       => true,
			'show_in_menu'  => true,
			'menu_position' => 30,
			'show_in_admin_bar' => true,
			'show_in_nav_menus' => false,
			'can_export'        => true,
			'exclude_from_search'   => true,
			'publicly_queryable'    => true,
			'menu_icon'             => 'dashicons-megaphone'
		];
		
		register_post_type( $this->post_type, $args );
	}
	
	public function add_meta_boxes()
	{
		add_meta_box( 'image_cta', __( 'Image CTA', $this['slug'] ), function() {
				$this['image_cta']->set_id( get_the_ID() );
				$this['image_cta_metabox']->render();
			}, 'hipcta_cta', 'normal', 'high' 
		);
		
		if ( get_post_type() !== 'hipcta_cta' ) {
			add_meta_box( 'post_flyout', __( 'Flyout Call-to-Action', $this['slug'] ), function() {
					$this['post_flyout_metabox']->render();
				}, NULL, 'side'
			);
		}
	}
	
	public function admin_scripts_and_styles()
	{
			if ( get_post_type() == 'hipcta_cta' ) {
					wp_enqueue_media();
					wp_enqueue_script(
							'hipcta_admin_js',
							plugins_url( '', dirname( __FILE__ ) ) . '/assets/js/hipcta_admin.js',
							['jquery', 'media-upload', 'media' ]
					);
					
					wp_enqueue_style( 
						'hipcta_admin_css', 
						$this['plugin_url'] . '/assets/css/admin.css',
						[],
						$this['version']
					);
			}
		wp_enqueue_script( 'flyout_admin_js', plugins_url( '', dirname( __FILE__ ) ) . '/assets/js/flyout_admin.js',
			['jquery']
		);
			

			
	}
	
	public function enqueue_scripts_and_styles()
	{
			wp_enqueue_script( 'flyout_js', plugins_url( '', dirname( __FILE__ ) ) . '/assets/js/flyout.js', ['jquery'] );
	}
	
	public static function add_cta( $options )
	{
			$post_args = [
					'post_title'    => ($options['name']) ? $options['name'] : '',
					'post_type'     => 'hipcta_cta',
					'post_status'   => 'publish'
			];
			
			if ( array_key_exists( 'id', $options ) ) {
				$post_args['ID'] = $options['id'];
			}
					
			$id = wp_insert_post( $post_args );
			
			update_post_meta( $id, 'hipcta', [ 
					'image' => $options['image'], 
					'link_url' => $options['link']
			] );
			
			return $id;
	}
    
	public function update_plugin()
	{
		$previous = get_option( 'hip-cta-version' );
		
		if ( ! $previous ) {
			$siren_posts = get_posts([
				'numberposts'	=> -1,
				'post_type'		=> 'siren_cta'
			]);
			
			if ( is_array($siren_posts) ) {
				foreach( $siren_posts as $post ) {
					$meta = get_post_meta( $post->ID, 'siren', true );
					\HipCTA\Plugin::add_cta( [
						'name'		=> $post->post_title,
						'image'		=> $meta['image'],
						'link'		=> $meta['link_url'],
						'id'			=> $post->ID
					] );
				}
			}
		}
		
		update_option( 'hip-cta-version', $this['version'] );
	}

	public function settings_page(){
		require_once $this['plugin_dir'] . '/src/HipCtaSettings.php';
		require_once $this['plugin_dir'] . '/src/HipCtaSettingsPage.php';
		require_once $this['plugin_dir'] . '/src/HipCtaSettingsAPI.php';
		add_action('rest_api_init',function(){
			$api = new \HipCta\SettingsAPI();
			$api->addRoutes();
		});
		new \HipCTA\SettingsPage([
			'post_type' => $this->post_type,
			'plugin_url' => $this['plugin_url']
		]);

	}

	public function  all_cta() {
		$args = [
			'numberposts' => -1,
			'post_type'     => 'hipcta_cta'
		];

		return get_posts( $args );
	}
}
