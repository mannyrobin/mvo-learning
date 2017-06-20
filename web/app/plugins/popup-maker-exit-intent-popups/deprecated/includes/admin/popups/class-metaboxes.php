<?php

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists( 'PopMake_Exit_Intent_Popups_Admin_Popup_Metaboxes' ) ) {

    /**
     * Main PopMake_Exit_Intent_Popups_Admin_Popup_Metaboxes class
     *
     * @since       1.0.0
     */
    class PopMake_Exit_Intent_Popups_Admin_Popup_Metaboxes {

        public function register() {
            /** Exit Popup Meta **/
            add_meta_box( 'popmake_popup_exit_intent', __( 'Exit Intent Popups Settings', 'popup-maker-exit-intent-popups' ),  array( $this, 'render_meta_box' ), 'popup', 'normal', 'high' );
        }

        public function meta_fields( $fields ) {
            return array_merge( $fields, array(
                'popup_exit_intent_defaults_set',
            ) );
        }

        public function meta_field_groups( $groups ) {
            return array_merge( $groups, array(
                'exit_intent',
            ) );
        }

        public function meta_field_group_exit_intent( $fields ) {
            return array_merge( $fields, array(
                'enabled',
                'type',
                'hard_message',
                'cookie_trigger',
                'cookie_time',
                'cookie_path',
                'cookie_key',
                'top_sensitivity',
                'delay_sensitivity',
            ));
        }

        public function defaults( $defaults ) {
            return array_merge( $defaults, array(
                'enabled' => NULL,
                'type' => 'soft',
                'hard_message' => __( 'Please take a moment to check out a special offer just for you!', 'popup-maker-exit-intent-popups' ),
                'cookie_trigger' => 'close',
                'cookie_time' => '1 month',
                'cookie_path' => '/',
                'cookie_key' => '',
                'top_sensitivity' => 10,
                'delay_sensitivity' => 350,
            ));
        }

        public function save_popup_exit_intent_cookie_key( $field = '' ) {
            if( $field == '' ) {
                $field = uniqid();
            }
            return $field;
        }

        public function type_options( $options ) {
            return array_merge( $options, array(
                __( 'Soft', 'popup-maker-exit-intent-popups' ) => 'soft',
                __( 'Hard', 'popup-maker-exit-intent-popups' ) => 'hard',
                __( 'Both', 'popup-maker-exit-intent-popups' ) => 'both',
                __( 'Hard Alert Only', 'popup-maker-exit-intent-popups' ) => 'alert',
           ) );
        }

        public function cookie_trigger_options( $options ) {
            return array_merge( $options, array(
                // option => value
                __( 'Disabled', 'popup-maker-auto-open-popups' ) => 'disabled',
                __( 'On Open', 'popup-maker-auto-open-popups' )  => 'open',
                __( 'On Close', 'popup-maker-auto-open-popups' ) => 'close',
                __( 'Manual', 'popup-maker-auto-open-popups' )   => 'manual',
            ) );
        }


        /**
         * Popup Exit Intent Popups Metabox
         *
         * Extensions (as well as the core plugin) can add items to the popup display
         * configuration metabox via the `popmake_popup_exit_intent_meta_box_fields` action.
         *
         * @since 1.0
         * @return void
         */
        public function render_meta_box() {
            global $post; ?>
            <input type="hidden" name="popup_exit_intent_defaults_set" value="true" />
            <div id="popmake_popup_exit_intent_fields" class="popmake_meta_table_wrap">
            <table class="form-table">
                <tbody>
                <?php do_action( 'popmake_popup_exit_intent_meta_box_fields', $post->ID );?>
                </tbody>
            </table>
            </div><?php
        }


    }
} // End if class_exists check