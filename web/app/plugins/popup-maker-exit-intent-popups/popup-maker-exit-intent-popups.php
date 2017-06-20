<?php
/**
 * Plugin Name: Popup Maker - Exit Intent Popups
 * Plugin URI: https://wppopupmaker.com/extensions/exit-intent-popups/
 * Description:
 * Version: 1.2.0
 * Author: WP Popup Maker
 * Author URI: https://wppopupmaker.com/
 * Text Domain: popup-maker-exit-intent-popups
 *
 * @package     PUM\Triggers\Exit
 * @author      WP Popup Maker
 * @copyright   Copyright (c) 2016, WP Popup Maker
 */


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class PUM_EIP
 */
class PUM_EIP {

	/**
	 * @var string Plugin Version
	 */
	public static $VER = '1.2';

	/**
	 * @var int DB Version
	 */
	public static $DB_VER = 3;

	/**
	 * @var string Text Domain
	 */
	public static $DOMAIN = 'popup-maker-exit-intent-popups';

	/**
	 * @var string Plugin Directory
	 */
	public static $DIR;

	/**
	 * @var string Plugin URL
	 */
	public static $URL;

	/**
	 * @var string Plugin FILE
	 */
	public static $FILE;

	/**
	 * Set up plugin variables.
	 */
	public static function setup_vars() {
		static::$FILE = __FILE__;
		static::$DIR  = plugin_dir_path( __FILE__ );
		static::$URL  = plugin_dir_url( __FILE__ );
	}

	/**
	 * Initialize the plugin.
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'textdomain' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'scripts' ) );
		add_filter( 'pum_get_triggers', array( __CLASS__, 'triggers' ) );
		add_filter( 'pum_get_trigger_labels', array( __CLASS__, 'trigger_labels' ) );

		static::maybe_update();
		
		// Handle licensing
		if ( class_exists( 'PopMake_License' ) ) {
			new PopMake_License( __FILE__, 'Exit Intent Popups', static::$VER, 'WP Popup Maker' );
		}
	}

	/**
	 * Load the textdomain for gettext translation.
	 */
	public static function textdomain() {
		$locale = apply_filters( 'plugin_locale', get_locale(), static::$DOMAIN );
		// wp-content/languages/plugin-name/plugin-name-de_DE.mo
		load_textdomain( static::$DOMAIN, trailingslashit( WP_LANG_DIR ) . static::$DOMAIN . '/' . static::$DOMAIN . '-' . $locale . '.mo' );
		// wp-content/plugins/plugin-name/languages/plugin-name-de_DE.mo
		load_plugin_textdomain( static::$DOMAIN, false, static::$DIR . 'languages/' );
	}

	/**
	 *
	 */
	public static function maybe_update() {

		$current_ver = get_option( 'pum_eip_ver', false );

		if ( ! $current_ver ) {
			$deprecated_ver = get_site_option( 'popmake_eip_version', false );
			$current_ver = $deprecated_ver ? $deprecated_ver : PUM_EIP::$VER;
			add_option( 'pum_eip_ver', PUM_EIP::$VER );
		}

		if ( version_compare( $current_ver, PUM_EIP::$VER, '<' ) ) {
			// Save Upgraded From option
			update_option( 'pum_eip_ver_upgraded_from', $current_ver );
			update_option( 'pum_eip_ver', PUM_EIP::$VER );
		}

		$current_db_version = get_option( 'pum_eip_db_ver', false );

		if ( ! $current_db_version ) {
			$updated_from = get_option( 'pum_eip_ver_upgraded_from', false );

			// If no updated install then this is fresh, no need to do anything.
			if ( ! $updated_from ) {
				$current_db_version = 3;
			} else {
				if ( version_compare( '1.1.1', $updated_from, '>=' ) ) {
					$current_db_version = 2;
				} else {
					$current_db_version = 3;
				}
			}

			update_option( 'pum_eip_db_ver', $current_db_version );

		}

		if ( $current_db_version < PUM_EIP::$DB_VER ) {
			if ( $current_db_version <= 2 ) {
				include_once PUM_EIP::$DIR . 'includes/upgrades/class-pum-eip-upgrade-routine-2.php';
				PUM_EIP_Upgrade_Routine_2::run();
				$current_db_version = 3;
			}

			update_option( 'pum_eip_db_ver', $current_db_version );
		}



	}
	
	/**
	 * Enqueue the needed scripts.
	 */
	public static function scripts() {
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		if ( ! is_admin() ) {
			wp_enqueue_script( 'pum-eip', static::$URL . 'assets/js/site' . $suffix . '.js?defer', array( 'popup-maker-site' ), static::$VER, true );
		}
	}

	/**
	 * Registers the exit intent trigger.
	 *
	 * @param array $triggers
	 *
	 * @return array
	 */
	public static function triggers( $triggers = array() ) {
		return array_merge( $triggers, array(
			'exit_intent'     => array(
				'fields' => array(
					'general' => array(
						'top_sensitivity'   => array(
							'label' => __( 'Top Sensitivity', 'popup-maker-exit-intent-popups' ),
							'desc'  => __( 'This defines the distance from the top of the browser window where the users mouse movement is detected.', 'popup-maker-exit-intent-popups' ),
							'type'  => 'rangeslider',
							'std'   => 10,
							'step'  => 1,
							'min'   => 1,
							'max'   => 50,
							'unit'  => __( 'px', 'popup-maker' ),
						),
						'delay_sensitivity' => array(
							'label' => __( 'False Positive Delay', 'popup-maker-exit-intent-popups' ),
							'desc'  => __( 'This defines the delay used for false positive detection. A higher value reduces false positives, but increases chances of not opening in time.', 'popup-maker-exit-intent-popups' ),
							'type'  => 'rangeslider',
							'std'   => 350,
							'step'  => 25,
							'min'   => 100,
							'max'   => 750,
							'unit'  => __( 'ms', 'popup-maker' ),
						),
					),
					'cookie'  => pum_trigger_cookie_fields(),
				),
			),
			'exit_prevention' => array(
				'fields' => array(
					'general' => array(
						'message' => array(
							'label'       => __( 'Prompt Message', 'popup-maker-exit-intent-popups' ),
							'desc'        => __( 'Enter the message displayed in the interrupt prompt.', 'popup-maker-exit-intent-popups' ),
							'placeholder' => __( 'Are you sure you want to leave?', 'popup-maker-exit-intent-popups' ),
							'std'         => __( 'Please take a moment to check out a special offer just for you!', 'popup-maker-exit-intent-popups' ),
						),

					),
					'cookie'  => pum_trigger_cookie_fields(),
				),
			)
		) );
	}

	/**
	 * Registers the exit intent trigger labels.
	 *
	 * @param array $labels
	 *
	 * @return array
	 */
	public static function trigger_labels( $labels = array() ) {
		return array_merge( $labels, array(
			'exit_intent'     => array(
				'name'            => __( 'Exit Intent', 'popup-maker-exit-intent-popups' ),
				'modal_title'     => __( 'Exit Intent Settings', 'popup-maker-exit-intent-popups' ),
				'settings_column' => sprintf(
					'<strong>%1$s</strong>: %2$s; <strong>%3$s</strong>: %4$s',
					__( 'Top', 'popup-maker-exit-intent-popups' ),
					'{{data.top_sensitivity}}',
					__( 'Delay', 'popup-maker-exit-intent-popups' ),
					'{{data.delay_sensitivity}}'
				),
			),
			'exit_prevention' => array(
				'name'            => __( 'Exit Prevention', 'popup-maker-exit-intent-popups' ),
				'modal_title'     => __( 'Exit Prevention Settings', 'popup-maker-exit-intent-popups' ),
				'settings_column' => sprintf(
					'<strong>%1$s</strong>: %2$s',
					__( 'Message', 'popup-maker-exit-intent-popups' ),
					'{{data.message}}'
				),
			),
		) );
	}

}


/**
 * Get the ball rolling. Fire up the correct version.
 *
 * @since       1.2.0
 */
function pum_eip_init() {
	if ( ! class_exists( 'Popup_Maker' ) && ! class_exists( 'PUM' ) ) {
		if ( ! class_exists( 'PUM_Extension_Activation' ) ) {
			require_once 'includes/pum-sdk/class-pum-extension-activation.php';
		}

		$activation = new PUM_Extension_Activation( plugin_dir_path( __FILE__ ), basename( __FILE__ ) );
		$activation->run();
	} else {

		// Set up variables for use in all versions.
		PUM_EIP::setup_vars();

		if ( function_exists( 'pum_is_v1_4_compatible' ) && pum_is_v1_4_compatible() ) {
			PUM_EIP::init();
		} else {
			// Here for backward compatibility with older versions of Popup Maker.
			require_once 'deprecated/class-popmake-exit-intent-popups.php';
			PopMake_Exit_Intent_Popups::instance();
		}

	}
}

add_action( 'plugins_loaded', 'pum_eip_init' );
