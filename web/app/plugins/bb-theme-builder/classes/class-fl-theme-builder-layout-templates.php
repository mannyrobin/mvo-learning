<?php

/**
 * Handles logic for theme layout templates.
 *
 * @since 1.0
 */
final class FLThemeBuilderLayoutTemplates {

	/**
	 * Initializes hooks.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function init() {
		self::register_templates();

		// Actions
		add_action( 'fl_builder_template_selector_data_type', __CLASS__ . '::template_selector_data_type' );
		add_action( 'fl_builder_after_save_user_template',    __CLASS__ . '::after_save_user_template' );

		// Filters
		add_filter( 'fl_builder_override_apply_template',     __CLASS__ . '::override_apply_template', 1, 2 );
	}

	/**
	 * Register theme layout templates.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function register_templates() {
		$templates = array(
			FL_THEME_BUILDER_DIR . 'data/templates-header.dat',
			FL_THEME_BUILDER_DIR . 'data/templates-footer.dat',
			FL_THEME_BUILDER_DIR . 'data/templates-singular.dat',
			FL_THEME_BUILDER_DIR . 'data/templates-archive.dat',
			FL_THEME_BUILDER_DIR . 'data/templates-404.dat',
		);

		foreach ( $templates as $path ) {
			if ( file_exists( $path ) ) {
				FLBuilder::register_templates( $path );
			}
		}
	}

	/**
	 * Sets the template selector data type for theme templates.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function template_selector_data_type( $type ) {
		global $post;

		if ( is_object( $post ) && 'fl-theme-layout' == $post->post_type && 'layout' == $type ) {

			$layout_type = get_post_meta( $post->ID, '_fl_theme_layout_type', true );
			$types       = array( 'header', 'footer', 'archive', 'singular', '404' );

			if ( $layout_type && in_array( $layout_type, $types ) ) {
				return $layout_type;
			}
		}

		return $type;
	}

	/**
	 * Overrides template data with theme layout template data
	 * when applying a core template.
	 *
	 * @since 1.0
	 * @param bool  $override
	 * @param array $data
	 * @return bool
	 */
	static public function override_apply_template( $override, $data ) {
		global $post;

		if ( is_object( $post ) && 'fl-theme-layout' == $post->post_type ) {

			$layout_type = get_post_meta( $post->ID, '_fl_theme_layout_type', true );
			$types       = array( 'header', 'footer', 'archive', 'singular', '404' );

			if ( $layout_type && in_array( $layout_type, $types ) ) {

				FLBuilderModel::apply_core_template( $data['index'], $data['append'], $layout_type );

				return true;
			}
		}

		return false;
	}

	/**
	 * Saves theme layout post meta along with user templates if
	 * the template being saved is of a theme layout.
	 *
	 * @since 1.0
	 * @param int $post_id
	 * @return void
	 */
	static public function after_save_user_template( $template_id ) {
		global $post;

		if ( is_object( $post ) && 'fl-theme-layout' == $post->post_type ) {

			$layout_type = get_post_meta( $post->ID, '_fl_theme_layout_type', true );

			if ( $layout_type ) {
				update_post_meta( $template_id, '_fl_theme_layout_type', $layout_type );
			}
		}
	}
}

FLThemeBuilderLayoutTemplates::init();
