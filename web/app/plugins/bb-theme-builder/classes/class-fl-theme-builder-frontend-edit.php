<?php

/**
 * Handles frontend editing UI logic for the builder.
 *
 * @since 1.0
 */
final class FLThemeBuilderFrontendEdit {

	/**
	 * Initializes hooks.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function init() {
		// Actions
		add_action( 'wp_enqueue_scripts', __CLASS__ . '::enqueue_scripts', 11 );
	}

	/**
	 * Enqueues styles and scripts for the editing UI.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function enqueue_scripts() {

		if ( ! FLBuilderModel::is_builder_active() ) {
			return;
		}

		//wp_enqueue_style( 'fl-theme-builder-frontend-edit', FL_THEME_BUILDER_URL . 'css/fl-theme-builder-frontend-edit.css', array(), FL_THEME_BUILDER_VERSION );

		wp_enqueue_script( 'fl-theme-builder-frontend-edit', FL_THEME_BUILDER_URL . 'js/fl-theme-builder-frontend-edit.js', array(), FL_THEME_BUILDER_VERSION );
	}
}

FLThemeBuilderFrontendEdit::init();
