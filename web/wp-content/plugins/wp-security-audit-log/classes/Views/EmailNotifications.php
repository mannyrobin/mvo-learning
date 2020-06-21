<?php
/**
 * View: Email Notifications Page
 *
 * WSAL email notifications page.
 *
 * @since 1.0.0
 * @package Wsal
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Email Notifications Add-On promo Page.
 * Used only if the plugin is not activated.
 *
 * @package Wsal
 */
class WSAL_Views_EmailNotifications extends WSAL_AbstractView {

	/**
	 * Get View Title.
	 */
	public function GetTitle() {
		return __( 'Notifications Add-On', 'wp-security-audit-log' );
	}

	/**
	 * Get View Icon.
	 */
	public function GetIcon() {
		return 'dashicons-external';
	}

	/**
	 * Get View Name.
	 */
	public function GetName() {
		return __( 'Notifications &#8682;', 'wp-security-audit-log' );
	}

	/**
	 * Get View Weight.
	 */
	public function GetWeight() {
		return 8;
	}

	/**
	 * Check if the page title is visible.
	 *
	 * @return boolean
	 */
	public function is_title_visible() {
		return false;
	}

	/**
	 * Get View Header.
	 */
	public function Header() {
		// Extension Page CSS.
		wp_enqueue_style(
			'extensions',
			$this->_plugin->GetBaseUrl() . '/css/extensions.css',
			array(),
			filemtime( $this->_plugin->GetBaseDir() . '/css/extensions.css' )
		);

		// Swipebox CSS.
		wp_enqueue_style(
			'wsal-swipebox-css',
			$this->_plugin->GetBaseUrl() . '/css/swipebox.min.css',
			array(),
			filemtime( $this->_plugin->GetBaseDir() . '/css/swipebox.min.css' )
		);
	}

	/**
	 * Get View Footer.
	 */
	public function Footer() {
		// jQuery.
		wp_enqueue_script( 'jquery' );

		// Swipebox JS.
		wp_register_script(
			'wsal-swipebox-js',
			$this->_plugin->GetBaseUrl() . '/js/jquery.swipebox.min.js',
			array( 'jquery' ),
			filemtime( $this->_plugin->GetBaseDir() . '/js/jquery.swipebox.min.js' ),
			false
		);
		wp_enqueue_script( 'wsal-swipebox-js' );

		// Extensions JS.
		wp_register_script(
			'wsal-extensions-js',
			$this->_plugin->GetBaseUrl() . '/js/extensions.js',
			array( 'wsal-swipebox-js' ),
			filemtime( $this->_plugin->GetBaseDir() . '/js/extensions.js' ),
			false
		);
		wp_enqueue_script( 'wsal-extensions-js' );
	}

	/**
	 * Page View.
	 */
	public function Render() {
		$title        = __( 'SMS & Email Notifications', 'wp-security-audit-log' );
		$description  = __( 'Get instantly alerted of important changes on your site via SMS and email notifications. Upgrade to premium and:', 'wp-security-audit-log' );
		$addon_img    = trailingslashit( WSAL_BASE_URL ) . 'img/' . $this->GetSafeViewName() . '.jpg';
		$premium_list = array(
			__( 'Configure any type of SMS & email notifications', 'wp-security-audit-log' ),
			__( 'Receive notifications for when users login, change their password or change content', 'wp-security-audit-log' ),
			__( 'Get alerted of site changes like plugin installs, theme changes etc', 'wp-security-audit-log' ),
			__( 'Enable built-in security email notifications of suspicious user activity', 'wp-security-audit-log' ),
			__( 'Personalize all email and SMS templates', 'wp-security-audit-log' ),
			__( 'Use the trigger builder to configure any type of notification criteria!', 'wp-security-audit-log' ),
		);
		$subtext      = __( 'Getting started is really easy. You can use one of the plugin’s built-in notifications or create your own using the easy to use trigger builder.', 'wp-security-audit-log' );
		$screenshots  = array(
			array(
				'desc' => __( 'Email and SMS notifications instantly alert you of important changes on your WordPress site.', 'wp-security-audit-log' ),
				'img'  => trailingslashit( WSAL_BASE_URL ) . 'img/notifications/notifications_1.png',
			),
			array(
				'desc' => __( 'Easily enable any of the built-in security and user management notifications.', 'wp-security-audit-log' ),
				'img'  => trailingslashit( WSAL_BASE_URL ) . 'img/notifications/notifications_2.png',
			),
			array(
				'desc' => __( 'Use the trigger builder to configure any type of email and SMS notification to get instantly alerted of site changes that are important to you and your business.', 'wp-security-audit-log' ),
				'img'  => trailingslashit( WSAL_BASE_URL ) . 'img/notifications/notifications_3.png',
			),
			array(
				'desc' => __( 'All email and SMS templates are configurable, allowing you to personalize them.', 'wp-security-audit-log' ),
				'img'  => trailingslashit( WSAL_BASE_URL ) . 'img/notifications/notifications_4.png',
			),
		);

		require_once dirname( __FILE__ ) . '/addons/html-view.php';
	}
}
