<?php
/**
 * Upgrade Routine 2
 *
 * @package     PUM
 * @subpackage  Admin/Upgrades
 * @copyright   Copyright (c) 2016, WP Popup Maker
 * @license     http://opensource.org/licenses/gpl-3.0.php GNU Public License
 * @since       1.2.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class PUM_EIP_Upgrade_Routine_2
 */
final class PUM_EIP_Upgrade_Routine_2 {

	/**
	 * @return string|void
	 */
	public static function description() {
		return __( 'Update your popups exit intent settings.', 'popup-maker' );
	}

	/**
	 *
	 */
	public static function run() {
		ignore_user_abort( true );

		if ( ! pum_is_func_disabled( 'set_time_limit' ) && ! ini_get( 'safe_mode' ) ) {
			@set_time_limit( 0 );
		}

		static::process_popups();
		static::cleanup_old_data();
	}

	/**
	 *
	 */
	public static function process_popups() {

		$popups = get_posts( array(
			'post_type'      => 'popup',
			'post_status'    => array( 'any', 'trash' ),
			'posts_per_page' => -1,
		) );

		if ( ! function_exists( 'popmake_get_popup_exit_intent' ) ) {
			include_once PUM_EIP::$DIR . 'deprecated/includes/functions.php';
		}

		foreach ( $popups as $popup ) {

			$popup = pum_popup( $popup->ID );

			$exit_intent = popmake_get_popup_exit_intent( $popup->ID );

			if ( ! $exit_intent || empty( $exit_intent['enabled'] ) || ! $exit_intent['enabled'] ) {
				continue;
			}

			$triggers = $popup->get_triggers();

			$cookies = $popup->get_cookies();

			// Empty placeholder arrays.
			$_triggers = $_cookies = array();

			$type = $exit_intent['type'];

			// Set the new cookie name.
			$cookie_name = 'popmake-exit-intent-' . $popup->ID;

			// Append the cookie key if set.
			if ( ! empty( $exit_intent['cookie_key'] ) ) {
				$cookie_name .= '-' . $exit_intent['cookie_key'];
			}

			// Store cookie_trigger for reuse.
			$cookie_trigger = $exit_intent['cookie_trigger'];

			// Create empty trigger cookie in case of disabled trigger.
			$trigger_cookie = null;

			// If cookie trigger not disabled create a new cookie and add it to the auto open trigger.
			if ( $cookie_trigger != 'disabled' ) {

				// Add the new cookie to the auto open trigger.
				$trigger_cookie = array( $cookie_name );

				// Set the event based on the original option.
				switch ( $cookie_trigger ) {
					case 'close':
						$event = 'on_popup_close';
						break;
					case 'open':
						$event = 'on_popup_close';
						break;
					default:
						$event = $cookie_trigger;
						break;
				}

				// Add the new cookie to the cookies array.
				$_cookies[] = array(
					'event'    => $event,
					'settings' => array(
						'name'    => $cookie_name,
						'key'     => '',
						'time'    => $exit_intent['cookie_time'],
						'path'    => isset( $exit_intent['cookie_path'] ) ? 1 : 0,
						'session' => isset( $exit_intent['session_cookie'] ) ? 1 : 0,
					),
				);
			}



			if ( 'soft' == $type || 'both' == $type ) {
				// Add the new auto open trigger to the triggers array.
				$_triggers[] = array(
					'type'     => 'exit_intent',
					'settings' => array(
						'top_sensitivity'  => ! empty( $exit_intent['top_sensitivity'] ) ? absint( $exit_intent['top_sensitivity'] ) : 10,
						'delay_sensitivity'  => ! empty( $exit_intent['delay_sensitivity'] ) ? absint( $exit_intent['delay_sensitivity'] ) : 350,
						'cookie' => array(
							'name' => $trigger_cookie,
						),
					),
				);
			}

			if ( 'hard' == $type || 'both' == $type ) {
				$_triggers[] = array(
					'type'     => 'exit_prevention',
					'settings' => array(
						'message'  => ! empty( $exit_intent['hard_message'] ) ? $exit_intent['delay'] : __( 'Please take a moment to check out a special offer just for you!', 'popup-maker-exit-intent-popups' ),
						'cookie' => array(
							'name' => $trigger_cookie,
						),
					),
				);
			}

			foreach ( $_cookies as $cookie ) {
				$cookie['settings'] = PUM_Cookies::instance()->validate_cookie( $cookie['event'], $cookie['settings'] );
				$cookies[]          = $cookie;
			}

			foreach ( $_triggers as $trigger ) {
				$trigger['settings'] = PUM_Triggers::instance()->validate_trigger( $trigger['type'], $trigger['settings'] );
				$triggers[]          = $trigger;
			}

			update_post_meta( $popup->ID, 'popup_triggers', $triggers );

			update_post_meta( $popup->ID, 'popup_cookies', $cookies );
		}

	}

	/**
	 *
	 */
	public static function cleanup_old_data() {
		global $wpdb;

		$meta_keys = array(
			'popup_exit_intent',
			'popup_exit_intent_enabled',
			'popup_exit_intent_type',
			'popup_exit_intent_hard_message',
			'popup_exit_intent_cookie_trigger',
			'popup_exit_intent_cookie_time',
			'popup_exit_intent_cookie_path',
			'popup_exit_intent_cookie_key',
			'popup_exit_intent_top_sensitivity',
			'popup_exit_intent_delay_sensitivity',
			'popup_exit_intent_defaults_set'
		);

		$meta_keys = implode( "','", $meta_keys );

		$wpdb->query( "DELETE FROM $wpdb->postmeta WHERE meta_key IN('$meta_keys');" );
	}

}