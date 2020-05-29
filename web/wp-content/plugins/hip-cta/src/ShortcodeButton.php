<?php 

namespace HipCTA;

class ShortcodeButton
{
	protected $container;
	
	public function __construct($container)
	{
		$this->container = $container;
		add_action('admin_init', [ $this, 'shortcodeButton' ]);
		add_action('admin_footer', [ $this, 'getCTA']);
	}

	public function shortcodeButton()	{
		if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {

			add_filter( 'mce_external_plugins', [ $this, 'addButtons' ] );
			add_filter( 'mce_buttons', [ $this, 'registerButtons' ] );

		}
	}
	
	public function addButtons( $plugin_array )
	{
		$plugin_array['hipcta'] = $this->container['plugin_url'] . '/assets/js/shortcode_button.js';
		return $plugin_array;
	}
	
	public function registerButtons($buttons)
	{
		array_push( $buttons, 'separator', 'hipcta' );
		return $buttons;
	}
	
	public function getCTA()
	{
		// Update this to use wp_localize_script
		$screen = get_current_screen();
		if((!empty($screen->action) && $screen->action == 'add') || !empty($screen->parent_base) && $screen->parent_base == 'edit'){
			$ctas = $this->container['all_cta'];
			$ctaList = [];
			foreach( $ctas as $cta ) {
				$ctaList[$cta->ID] = $cta->post_title;
			}
			echo '<script type="text/javascript" id="hip-cta">';
			echo 'var hipcta_all_ctas = ' . json_encode( $ctaList ) . ';';
			echo '</script>';
		}

	}
}
