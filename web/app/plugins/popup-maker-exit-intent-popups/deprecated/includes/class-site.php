<?php

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists( 'PopMake_Exit_Intent_Popups_Site' ) ) {

    /**
     * Main PopMake_Exit_Intent_Popups_Site class
     *
     * @since       1.0.0
     */
    class PopMake_Exit_Intent_Popups_Site {

		public function popup_data_attr( $data_attr, $popup_id ) {
			if( popmake_get_popup_exit_intent( $popup_id, 'enabled' ) ) {
				$data_attr['meta']['exit_intent'] = popmake_get_popup_exit_intent( $popup_id );
			}
			return $data_attr;
		}

		public function popup_classes( $classes, $popup_id ) {
			if( popmake_get_popup_exit_intent( $popup_id, 'enabled' ) ) {
				$classes[] = 'exit-intent';
			}
			return $classes;
		}

		/**
		 * Load frontend scripts
		 *
		 * @since       1.0.0
		 * @return      void
		 */
		public function scripts() {
			// Use minified libraries if SCRIPT_DEBUG is turned off
			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
			wp_register_script( 'pum-exit-intent', POPMAKE_EXITINTENTPOPUPS_URL . 'assets/js/site' . $suffix . '.js?defer', array( 'popup-maker-site' ), POPMAKE_EXITINTENTPOPUPS_VER, true );
		}

	    public function enqueue_scripts( $scripts = array(), $popup_id = NULL ) {
		    if( ! is_null( $popup_id ) && popmake_get_popup_exit_intent( $popup_id, 'enabled' ) ) {
			    $scripts['exit-intent'] = 'popmake-exit-intent-popups-js';
		    }
		    return $scripts;
	    }


    }
} // End if class_exists check
