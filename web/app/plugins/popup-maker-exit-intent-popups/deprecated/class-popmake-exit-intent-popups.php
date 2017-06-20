<?php

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main PopMake_Exit_Intent_Popups class
 *
 * @since       1.0.0
 */
class PopMake_Exit_Intent_Popups {

	/**
	 * @var         PopMake_Exit_Intent_Popups $instance The one true PopMake_Exit_Intent_Popups
	 * @since       1.0.0
	 */
	private static $instance;

	public $site;
	public $admin;

	/**
	 * Get active instance
	 *
	 * @access      public
	 * @since       1.0.0
	 * @return      object self::$instance The one true PopMake_Exit_Intent_Popups
	 */
	public static function instance() {
		if( !self::$instance ) {
			self::$instance = new PopMake_Exit_Intent_Popups();
			self::$instance->setup_constants();
			self::$instance->includes();
			self::$instance->load_textdomain();

			self::$instance->site =  new PopMake_Exit_Intent_Popups_Site();
			self::$instance->admin =  new PopMake_Exit_Intent_Popups_Admin();

			self::$instance->register_fields();
			self::$instance->hooks();
		}

		return self::$instance;
	}


	/**
	 * Setup plugin constants
	 *
	 * @access      private
	 * @since       1.0.0
	 * @return      void
	 */
	private function setup_constants() {
		// Plugin version
		define( 'POPMAKE_EXITINTENTPOPUPS_VER', PUM_EIP::$VER );

		// Plugin path
		define( 'POPMAKE_EXITINTENTPOPUPS_DIR', plugin_dir_path( __FILE__ ) );

		// Plugin URL
		define( 'POPMAKE_EXITINTENTPOPUPS_URL', plugin_dir_url( __FILE__ ) );
	}


	/**
	 * Include necessary files
	 *
	 * @access      private
	 * @since       1.0.0
	 * @return      void
	 */
	private function includes() {
		// Include scripts
		require_once POPMAKE_EXITINTENTPOPUPS_DIR . 'includes/class-site.php';
		require_once POPMAKE_EXITINTENTPOPUPS_DIR . 'includes/class-admin.php';
		require_once POPMAKE_EXITINTENTPOPUPS_DIR . 'includes/admin/popups/class-metaboxes.php';
		require_once POPMAKE_EXITINTENTPOPUPS_DIR . 'includes/admin/popups/class-metabox-fields.php';
		require_once POPMAKE_EXITINTENTPOPUPS_DIR . 'includes/functions.php';
	}


	/**
	 * Run action and filter hooks
	 *
	 * @access      private
	 * @since       1.0.0
	 * @return      void
	 */
	private function hooks() {
		add_action( 'wp_enqueue_scripts', array( $this->site, 'scripts' ) );
		add_filter( 'popmake_get_the_popup_classes', array( $this->site, 'popup_classes' ), 5, 2 );
		add_filter( 'popmake_get_the_popup_data_attr', array( $this->site, 'popup_data_attr' ), 0, 2 );
		add_filter( 'popmake_enqueue_scripts', array( $this->site, 'enqueue_scripts' ), 10, 2 );

		add_action( 'admin_enqueue_scripts', array( $this->admin, 'scripts' ), 100 );
		add_action( 'add_meta_boxes', array( $this->admin->metaboxes, 'register' ) );
		add_filter( 'popmake_popup_meta_fields', array( $this->admin->metaboxes, 'meta_fields' ) );
		add_filter( 'popmake_popup_meta_field_groups', array( $this->admin->metaboxes, 'meta_field_groups' ) );
		add_filter( 'popmake_popup_meta_field_group_exit_intent', array( $this->admin->metaboxes, 'meta_field_group_exit_intent' ) );
		add_filter( 'popmake_popup_exit_intent_defaults', array( $this->admin->metaboxes, 'defaults' ) );
		add_filter( 'popmake_eip_exit_popup_type_options', array( $this->admin->metaboxes, 'type_options' ) );
		add_filter( 'popmake_eip_cookie_trigger_options', array( $this->admin->metaboxes, 'cookie_trigger_options' ), 10 );
		add_filter( 'popmake_metabox_save_popup_exit_intent_cookie_key', array( $this->admin->metaboxes, 'save_popup_exit_intent_cookie_key' ) );

		add_action( 'popmake_popup_exit_intent_meta_box_fields', array( $this->admin->metabox_fields, 'enabled' ), 10 );
		add_action( 'popmake_popup_exit_intent_meta_box_fields', array( $this->admin->metabox_fields, 'type' ), 20 );
		add_action( 'popmake_popup_exit_intent_meta_box_fields', array( $this->admin->metabox_fields, 'top_sensitivity' ), 30 );
		add_action( 'popmake_popup_exit_intent_meta_box_fields', array( $this->admin->metabox_fields, 'delay_sensitivity' ), 40 );
		add_action( 'popmake_popup_exit_intent_meta_box_fields', array( $this->admin->metabox_fields, 'hard_message' ), 50 );
		add_action( 'popmake_popup_exit_intent_meta_box_fields', array( $this->admin->metabox_fields, 'cookie_trigger' ), 60 );
		add_action( 'popmake_popup_exit_intent_meta_box_fields', array( $this->admin->metabox_fields, 'cookie_time' ), 70 );
		add_action( 'popmake_popup_exit_intent_meta_box_fields', array( $this->admin->metabox_fields, 'cookie_path' ), 80 );
		add_action( 'popmake_popup_exit_intent_meta_box_fields', array( $this->admin->metabox_fields, 'cookie_key' ), 90 );

		if ( is_admin() ) {
			add_action( 'after_setup_theme', array( $this->admin, 'install_check' ) );
		}

		// Handle licensing
		if ( class_exists( 'PopMake_License' ) ) {
			new PopMake_License( PUM_EIP::$FILE, 'Exit Intent Popups', PUM_EIP::$VER, 'WP Popup Maker' );
		}
	}


	public function register_fields() {
		
		if ( version_compare( POPMAKE_VERSION, '1.3', '>=' ) ) {

			Popmake_Popup_Fields::instance()->register_section(
				'exit_intent',
				__( 'Exit Intent Settings', 'popup-maker-exit-intent-popups' )
			);

			Popmake_Popup_Fields::instance()->add_fields( 'exit_intent', array(
				'enabled'        => array(
					'label'       => __( 'Enable Exit Intent', 'popup-maker-exit-intent-popups' ),
					'description' => __( 'Checking this will cause popup to open when the user tries to leave your site.', 'popup-maker-exit-intent-popups' ),
					'type'        => 'checkbox',
					'std'         => false,
					'priority'    => 0,
				),
				'type'         => array(
					'class' => 'exit-intent-enabled',
					'label'       => __( 'Type', 'popup-maker-exit-intent-popups' ),
					'description' => __( 'Choose the type of exit prevention to use.', 'popup-maker-exit-intent-popups' ),
					'type'        => 'select',
					'std'         => 'soft',
					'priority'    => 5,
					'options'     => apply_filters( 'popmake_eip_exit_popup_type_options', array(
						__( 'Soft', 'popup-maker-exit-intent-popups' ) => 'soft',
						__( 'Hard', 'popup-maker-exit-intent-popups' ) => 'hard',
						__( 'Both', 'popup-maker-exit-intent-popups' ) => 'both',
						__( 'Hard Alert Only', 'popup-maker-exit-intent-popups' ) => 'alert',
					) )
				),
				'top_sensitivity' => array(
					'class' => 'exit-intent-enabled soft-only',
					'label'       => __( 'Top Sensitivity', 'popup-maker-exit-intent-popups' ),
					'description' => __( 'This defines the distance from the top of the browser window where the users mouse movement is detected.', 'popup-maker-exit-intent-popups' ),
					'type'        => 'rangeslider',
					'std'         => 10,
					'priority'    => 10,
					'step'        => apply_filters( 'popup_exit_intent_top_sensitivity_step', 1 ),
					'min'         => apply_filters( 'popup_exit_intent_top_sensitivity_min', 1 ),
					'max'         => apply_filters( 'popup_exit_intent_top_sensitivity_max', 50 ),
					'unit'        => __( 'px', 'popup-maker-exit-intent-popups' ),
				),
				'delay_sensitivity' => array(
					'class' => 'exit-intent-enabled soft-only',
					'label'       => __( 'False Positive Delay', 'popup-maker-exit-intent-popups' ),
					'description' => __( 'This defines the delay used for false positive detection. A higher value reduces false positives, but increases chances of not opening in time.', 'popup-maker-exit-intent-popups' ),
					'type'        => 'rangeslider',
					'std'         => 350,
					'priority'    => 15,
					'step'        => apply_filters( 'popup_exit_intent_delay_sensitivity_step', 25 ),
					'min'         => apply_filters( 'popup_exit_intent_delay_sensitivity_min', 100 ),
					'max'         => apply_filters( 'popup_exit_intent_delay_sensitivity_max', 750 ),
					'unit'        => __( 'ms', 'popup-maker-exit-intent-popups' ),
				),
				'hard_message'    => array(
					'class' => 'exit-intent-enabled hard-only',
					'label'       => __( 'Prompt Message', 'popup-maker-exit-intent-popups' ),
					'placeholder' => __( 'Are you sure you want to leave?', 'popup-maker-exit-intent-popups' ),
					'description' => __( 'Enter the message displayed in the interrupt prompt.', 'popup-maker-exit-intent-popups' ),
					'std'         => __( 'Please take a moment to check out a special offer just for you!', 'popup-maker-exit-intent-popups' ),
					'priority'    => 20,
				),
				'cookie_trigger' => array(
					'class' => 'exit-intent-enabled',
					'label'       => __( 'Cookie Trigger', 'popup-maker' ),
					'description' => __( 'When do you want to create the cookie.', 'popup-maker' ),
					'type'        => 'select',
					'std'         => 'close',
					'priority'    => 25,
					'options'     => apply_filters( 'popmake_eip_cookie_trigger_options', array(
						__( 'Disabled', 'popup-maker' ) => 'disabled',
						__( 'On Open', 'popup-maker' )  => 'open',
						__( 'On Close', 'popup-maker' ) => 'close',
						__( 'Manual', 'popup-maker' )   => 'manual',
					) ),
				),
				'cookie_time'    => array(
					'class' => 'exit-intent-enabled',
					'label'       => __( 'Cookie Time', 'popup-maker' ),
					'placeholder' => __( '364 days 23 hours 59 minutes 59 seconds', 'popup-maker' ),
					'description' => __( 'Enter a plain english time before cookie expires.', 'popup-maker' ),
					'std'         => '1 month',
					'priority'    => 30,
				),
				'cookie_path'    => array(
					'class' => 'exit-intent-enabled',
					'label'       => __( 'Sitewide Cookie', 'popup-maker' ),
					'description' => __( '	This will prevent the popup from auto opening on any page until the cookie expires.', 'popup-maker' ),
					'type'        => 'checkbox',
					'std'         => true,
					'priority'    => 35,
				),
				'cookie_key'     => array(
					'class' => 'exit-intent-enabled',
					'label'       => __( 'Cookie Key', 'popup-maker' ),
					'description' => __( 'Resetting this will cause all existing cookies to be invalid.', 'popup-maker' ),
					'std'         => '',
					'priority'    => 40,
				),
			) );

		}

	}


	/**
	 * Internationalization
	 *
	 * @access      public
	 * @since       1.0.0
	 * @return      void
	 */
	public function load_textdomain() {
		// Set filter for language directory
		$lang_dir = POPMAKE_EXITINTENTPOPUPS_DIR . '/languages/';
		$lang_dir = apply_filters( 'popmake_eip_languages_directory', $lang_dir );

		// Traditional WordPress plugin locale filter
		$locale = apply_filters( 'plugin_locale', get_locale(), 'popup-maker-exit-intent-popups' );
		$mofile = sprintf( '%1$s-%2$s.mo', 'popup-maker-exit-intent-popups', $locale );

		// Setup paths to current locale file
		$mofile_local   = $lang_dir . $mofile;
		$mofile_global  = WP_LANG_DIR . '/popup-maker-exit-intent-popups/' . $mofile;

		if( file_exists( $mofile_global ) ) {
			// Look in global /wp-content/languages/popup-maker-exit-intent-popups/ folder
			load_textdomain( 'popup-maker-exit-intent-popups', $mofile_global );
		} elseif( file_exists( $mofile_local ) ) {
			// Look in local /wp-content/plugins/popup-maker-exit-intent-popups/languages/ folder
			load_textdomain( 'popup-maker-exit-intent-popups', $mofile_local );
		} else {
			// Load the default language files
			load_plugin_textdomain( 'popup-maker-exit-intent-popups', false, $lang_dir );
		}
	}
}

function PopMake_Exit_Intent_Popups() {
	return PopMake_Exit_Intent_Popups::instance();
}
