<?php
/**
 * Form Abandonment.
 *
 * @package    WPFormsFormAbandonment
 * @author     WPForms
 * @since      1.0.0
 * @license    GPL-2.0+
 * @copyright  Copyright (c) 2017, WPForms LLC
*/
class WPForms_Form_Abandonment {

	/**
	 * Primary class constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		$this->init();
	}

	/**
	 * Initialize.
	 *
	 * @since 1.0.0
	 */
	public function init() {

		// Admin related Actions/Filters
		add_action( 'wpforms_builder_enqueues',                         array( $this, 'admin_enqueues'                  )        );
		add_filter( 'wpforms_builder_settings_sections',                array( $this, 'settings_register'               ), 20, 2 );
		add_action( 'wpforms_form_settings_panel_content',              array( $this, 'settings_content'                ), 20, 2 );
		add_action( 'wpforms_form_settings_notifications_single_after', array( $this, 'notification_settings'           ), 10, 2 );
		add_filter( 'wpforms_entries_table_counts',                     array( $this, 'entries_table_counts'            ), 10, 2 );
		add_filter( 'wpforms_entries_table_views',                      array( $this, 'entries_table_views'             ), 10, 3 );
		add_filter( 'wpforms_entries_table_column_status',              array( $this, 'entries_table_column_status'     ), 10, 2 );
		add_filter( 'wpforms_entry_details_sidebar_details_status',     array( $this, 'entries_details_sidebar_status'  ), 10, 3 );
		add_filter( 'wpforms_entry_details_sidebar_actions_link',       array( $this, 'entries_details_sidebar_actions' ), 10, 3 );
		add_action( 'wp_ajax_wpforms_form_abandonment',                 array( $this, 'process_entries'                 )        );
		add_action( 'wp_ajax_nopriv_wpforms_form_abandonment',          array( $this, 'process_entries'                 )        );
		add_filter( 'wpforms_entry_email_process',                      array( $this, 'process_email'                   ), 10, 5 );

		// Front-end related Actions/Filters
		add_action( 'wpforms_frontend_container_class',                array( $this, 'form_container_class'             ), 10, 2 );
		add_action( 'wpforms_wp_footer',                               array( $this, 'frontend_enqueues'                )        );
	}

	//************************************************************************//
	//
	//	Admin-side functionality
	//
	//************************************************************************//

	/**
	 * Enqueue assets for the builder.
	 *
	 * @since 1.0.0
	 */
	public function admin_enqueues() {

		$suffix  = ( ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) || ( defined( 'WPFORMS_DEBUG' ) && WPFORMS_DEBUG )  ) ? '' : '.min';

		wp_enqueue_script(
			'wpforms-builder-form-abandonment',
			plugin_dir_url( __FILE__ ) . 'assets/js/admin-builder-form-abandonment' . $suffix . '.js',
			array( 'jquery' ),
			WPFORMS_FORM_ABANDONMENT_VERSION,
			false
		);
	}

	/**
	 * Form Abandonmentsettings register section.
	 *
	 * @since 1.0.0
	 * @param array $sections
	 * @param array $form_data
	 */
	public function settings_register( $sections, $form_data ) {

		$sections['form_abandonment'] = __( 'Form Abandonment', 'wpforms_form_abandonment' );

		return $sections;
	}

	/**
	 * Form Abandonment settings content.
	 *
	 * @since 1.0.0
	 * @param object $instance
	 */
	public function settings_content( $instance ) {

		echo '<div class="wpforms-panel-content-section wpforms-panel-content-section-form_abandonment">';

			echo '<div class="wpforms-panel-content-section-title">';
				_e( 'Form Abandonment', 'wpforms_form_abandonment' );
				echo '<a href="https://wpforms.com/docs/how-to-install-and-use-form-abandonment-with-wpforms/" target="_blank" rel="noopener"><i class="fa fa-question-circle wpforms-help-tooltip" title="' . __( 'Click here for documentation on Form Abandonment addon', 'wpforms_form_abandonment' ) . '"></i></a>';
			echo '</div>';

			wpforms_panel_field(
				'checkbox',
				'settings',
				'form_abandonment',
				$instance->form_data,
				__( 'Enable form abandonment lead capture', 'wpforms_form_abandonment' )
			);

			wpforms_panel_field(
				'radio',
				'settings',
				'form_abandonment_fields',
				$instance->form_data,
				'',
				array(
					'options' => array(
						'' => array(
							'label' => __( 'Save only if email address or phone number is provided', 'wpforms_form_abandonment' ),
						),
						'all' => array(
							'label'   => __( 'Always save abandoned entries', 'wpforms_form_abandonment' ),
							'tooltip' => __( 'We believe abandoned form entries are only helpful if you have some way to contact the user. However this option is good for users that have  anonymous form submissions.', 'wpforms_form_abandonment' ),
						)
					)
				)
			);

			wpforms_panel_field(
				'checkbox',
				'settings',
				'form_abandonment_duplicates',
				$instance->form_data,
				__( 'Prevent duplicate abandon entries', 'wpforms_form_abandonment' ),
				array(
					'tooltip' => __( 'When checked only the most recent abandoned entry from the user is saved. See the Form Abandonment documentation for more info regarding this setting.', 'wpforms_form_abandonment' ),
				)
			);

		echo '</div>';
	}

	/**
	 * Add select to form notification settings.
	 *
	 * @since 1.0.0
	 * @param object $settings
	 * @param int $id
	 */
	public function notification_settings( $settings, $id ) {

		// Only display if they have turned on form abandoment for the form
		// and have saved.
		if ( ! $this->has_form_abandonment( $settings->form_data ) ) {
			return;
		}

		wpforms_panel_field(
			'checkbox',
			'notifications',
			'form_abandonment',
			$settings->form_data,
			__( 'Enable for abandoned forms entries', 'wpforms_form_abandonment' ),
			array(
				'parent'     => 'settings',
				'subsection' => $id,
				'tooltip'    => __( 'When enabled this notification will <i>only</i> send for abandoned form entries. This setting should only be used with <strong>new</strong> notifications.', 'wpforms_form_abandonment' ),
			)
		);
	}

	/**
	 * Lookup and store counts for abandoned entries.
	 *
	 * @since 1.0.0
	 * @param array $counts
	 * @param array $form_data
	 * @return array
	 */
	public function entries_table_counts( $counts, $form_data ) {

		if ( $this->has_form_abandonment( $form_data ) ) {
			$counts['abandoned'] = wpforms()->entry->get_entries( array( 'form_id' => absint( $form_data['id'] ), 'status' => 'abandoned' ), true );
		}

		return $counts;
	}

	/**
	 * Create view for abandoned entries.
	 *
	 * @since 1.0.0
	 * @param array $counts
	 * @param array $form_data
	 * @param array $counts
	 * @return array
	 */
	public function entries_table_views( $views, $form_data, $counts ) {

		if ( $this->has_form_abandonment( $form_data ) ) {

			$base = add_query_arg(
				array(
					'page'    => 'wpforms-entries',
					'view'    => 'list',
					'form_id' => absint( $form_data['id'] ),
				),
				admin_url( 'admin.php' )
			);

			$current   = isset( $_GET['status'] ) ? $_GET['status'] : '';
			$abandoned = '&nbsp;<span class="count">(<span class="abandoned-num">' . $counts['abandoned']  . '</span>)</span>';

			$views['abandoned'] = sprintf( '<a href="%s"%s>%s</a>', esc_url( add_query_arg( 'status', 'abandoned', $base ) ), $current === 'abandoned' ? ' class="current"' : '', __( 'Abandoned', 'wpforms_form_abandonment' ) . $abandoned );
		}

		return $views;
	}

	/**
	 * Enable the Status column for forms that have are using form abandonment.
	 *
	 * @since 1.0.0
	 * @param bool $show
	 * @param array $form_data
	 * @return bool
	 */
	public function entries_table_column_status( $show, $form_data ) {

		if ( $this->has_form_abandonment( $form_data ) ) {
			return true;
		}

		return $show;
	}

	/**
	 * Enable the displaying status for forms that are using form abandonment
	 *
	 * @since [version]
	 * @param [type] $entry
	 * @param [type] $form_data
	 * @return [type]
	 */
	public function entries_details_sidebar_status( $show, $entry, $form_data ) {

		if ( $this->has_form_abandonment( $form_data ) ) {
			return true;
		}

		return $show;
	}

	/**
	 * For abandoned entries remove the link to resend email notifications.
	 *
	 * @since 1.0.0
	 * @param array $links
	 * @param array $entry
	 * @param array $form_data
	 * @return array
	 */
	public function entries_details_sidebar_actions( $links, $entry, $form_data ) {

		if ( $this->has_form_abandonment( $form_data ) ) {
			unset( $links['notifications'] );
		}

		return $links;
	}

	/**
	 * Process the abandoned entries via AJAX.
	 *
	 * @since 1.0.0
	 */
	public function process_entries() {

		// Make sure we have required data
		if ( empty( $_POST['forms'] ) ) {
			wp_send_json_error();
		}

		// User UID is required
		if ( empty( $_COOKIE['_wpfuuid'] ) ) {
			wp_send_json_error();
		}

		// Grab posted data and decode
		$data  = json_decode( stripslashes( $_POST['forms'] ) );
		$forms = array();

		// Compile all posted data into an array
		foreach ( $data as $form_id => $form ) {

			$fields = array();

			foreach ( $form as $post_input_data ) {

				preg_match( '#([^\[]*)(\[(.+)\])?#', $post_input_data->name, $matches );

				$array_bits = array( $matches[1] );

				if ( isset( $matches[3] ) ) {
					$array_bits = array_merge( $array_bits, explode( '][', $matches[3] ) );
				}

				$new_post_data = array();

				for ( $i = count( $array_bits ) - 1; $i >= 0; $i -- ) {
					if ( $i == count( $array_bits ) - 1 ) {
						$new_post_data[ $array_bits[ $i ] ] = wp_slash( $post_input_data->value );
					} else {
						$new_post_data = array( $array_bits[ $i ] => $new_post_data );
					}
				}

				$fields = array_replace_recursive( $fields, $new_post_data );
			}

			$forms[$form_id] = $fields['wpforms'];
		}

		// Go through the data for each form abandoned (if multiple) and process
		foreach( $forms as $form_id => $entry ) {

			wpforms()->process->fields = array();

			// Get the form settings for this form
			$form = wpforms()->form->get( $form_id );

			// Form must be real and active (published)
			if ( ! $form || 'publish' != $form->post_status ) {
				wp_send_json_error();
			}

			// If the honeypot was triggers we assume this is a spammer
			if ( !empty( $entry['hp'] ) ) {
				wp_send_json_error();
			}

			// Formatted form data
			$form_data = apply_filters( 'wpforms_process_before_form_data_form_abandonment', wpforms_decode( $form->post_content ), $entry );

			// Pre-process filter
			$entry = apply_filters( 'wpforms_process_before_filter_form_abandonment', $entry, $form_data );

			$exists          = false;
			$avoid_dupes     = !empty( $form_data['settings']['form_abandonment_duplicates'] );
			$fields_required = empty( $form_data['settings']['form_abandonment_fields'] );
			$email_phone     = false;

			// Format fields
			foreach ( $form_data['fields'] as $field ) {

				$field_id     = $field['id'];
				$field_type   = $field['type'];
				$field_submit = isset( $entry['fields'][$field_id] ) ? $entry['fields'][$field_id] : '';

				// Don't support these fields for abandonment tracking
				if ( in_array( $file_type, array( 'file-upload', 'signature' ) ) ) {
					continue;
				}

				if ( in_array( $field_type, array( 'phone', 'email' ) ) && !empty( $field_submit ) ) {
					$email_phone = true;
				}

				do_action( "wpforms_process_format_{$field_type}", $field_id, $field_submit, $form_data );
			}

			// If the form has phone/email required but neither is present then
			// stop processing
			if ( $fields_required && ! $email_phone ) {
				continue;
			}

			// Post-process filter
			$fields = apply_filters( 'wpforms_process_filter_form_abandonment', wpforms()->process->fields, $entry, $form_data );

			// Post-process hook
			do_action( 'wpforms_process_form_abandonment', $fields, $entry, $form_data );

			// Here we check to see if the user has had another abaondoned entry
			// for this form within the last hour. If so, then update the
			// existing entry instead of creating a new one.
			if ( $avoid_dupes ) {

				global $wpdb;

				$exists = $wpdb->get_row(
					$wpdb->prepare(
						"SELECT entry_id FROM {$wpdb->prefix}wpforms_entries WHERE `form_id` = %d AND `user_uuid` = %s AND `status` = 'abandoned' AND `date` >= DATE_SUB(NOW(),INTERVAL 1 HOUR) LIMIT 1;",
						absint( $form_id ),
						sanitize_text_field( $_COOKIE['_wpfuuid'] )
					)
				);
			}

			if ( !empty( $exists ) ) {
				// Updating a previous abandoned entry made within the last hour
				$entry_id = $exists->entry_id;

				// Prepare the args to be updated
				$data = array(
					'viewed' => 0,
					'fields' => json_encode( $fields ),
					'date'   => date( 'Y-m-d H:i:s' ),
				);

				// Update
				wpforms()->entry->update( $entry_id , $data );

			} else {
				// Adding a new abandoned entry

				// Get the user details
				$user_id    = is_user_logged_in() ? get_current_user_id() : 0;
				$user_ip    = wpforms_get_ip();
				$user_agent = !empty( $_SERVER['HTTP_USER_AGENT'] ) ? substr( $_SERVER['HTTP_USER_AGENT'], 0, 256 ) : '';
				$user_uuid  = !empty( $_COOKIE['_wpfuuid'] ) ? $_COOKIE['_wpfuuid'] : '';

				// Prepare the args to be saved
				$data = array(
					'form_id'    => absint( $form_id ),
					'user_id'    => absint( $user_id ),
					'status'     => 'abandoned',
					'fields'     => json_encode( $fields ),
					'ip_address' => sanitize_text_field( $user_ip ),
					'user_agent' => sanitize_text_field( $user_agent ),
					'user_uuid'  => sanitize_text_field( $user_uuid ),
				);

				// Save
				$entry_id = wpforms()->entry->add( $data );
			}

			// Send notification emails if configured
			wpforms()->process->entry_email( $fields, array(), $form_data, $entry_id, 'abandoned' );

			// Boom.
			do_action( 'wpforms_process_complete_form_abandonment', $fields, $entry, $form_data, $entry_id );
		}

		wp_send_json_success();
	}

	/**
	 * Logic that helps decide if we should send abandoned entries notifications.
	 *
	 * @since 1.0.0
	 * @param bool $process
	 * @param array $field
	 * @param array $form_data
	 * @param int $notification_id
	 * @param string $context
	 * @return bool
	 */
	public function process_email( $process, $fields, $form_data, $notification_id, $context ) {

		if ( ! $process ) {
			return false;
		}

		if ( ! $this->has_form_abandonment( $form_data ) && 'abandoned' == $context ) {
			// If form abandonment for the form is disabled, never send notifications
			// for form abandonment
			return false;
		} else if ( 'abandoned' == $context ) {
			// Notifications triggered due to abandoned entry, don't send unless
			// the notification is enabled for form abandonment
			if ( empty( $form_data['settings']['notifications'][$notification_id]['form_abandonment'] ) ) {
				return false;
			}
		} else {
			// Notifications triggered due to normal entry, don't send if
			// notification is enable for form abandoment
			if ( !empty( $form_data['settings']['notifications'][$notification_id]['form_abandonment'] ) ) {
				return false;
			}
		}

		return $process;
	}


	//************************************************************************//
	//
	//	Front-end functionality
	//
	//************************************************************************//

	/**
	 * Add form class if form abandonment is enabled.
	 *
	 * @since 1.0.0
	 * @param array $class
	 * @param array $form_data
	 * @return array
	 */
	public function form_container_class( $class, $form_data ) {

		if ( $this->has_form_abandonment( $form_data ) ) {
			$class[] = 'wpforms-form-abandonment';
		}

		return $class;
	}

	/**
	 * Enqueue assets in the frontend. Maybe.
	 *
	 * @since 1.0.0
	 */
	public function frontend_enqueues( $forms ) {

		$enabled = false;
		$global  = apply_filters( 'wpforms_global_assets', wpforms_setting( 'global-assets', false ) );
		$suffix  = ( ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) || ( defined( 'WPFORMS_DEBUG' ) && WPFORMS_DEBUG )  ) ? '' : '.min';

		foreach ( $forms as $form ) {
			if ( $this->has_form_abandonment( $form ) ) {
				$enabled = true;
				break;
			}
		}

		// If a form on the page is has form abandonment enabled or global asset
		// loading is turned on load our js.
		if ( $enabled || $global ) {
			wp_enqueue_script(
				'wpforms-form-abandonment',
				plugin_dir_url( __FILE__ ) . 'assets/js/wpforms-form-abandonment' . $suffix . '.js',
				array( 'jquery' ),
				WPFORMS_FORM_ABANDONMENT_VERSION
			);
			$vars = array(
				'ajaxurl'  => admin_url( 'admin-ajax.php' ),
				'home_url' => home_url(),
			);
			wp_localize_script( 'wpforms-form-abandonment', 'wpforms_form_abandonment', $vars );
		}
	}

	//************************************************************************//
	//
	//	Misc
	//
	//************************************************************************//

	/**
	 * Helper function that checks if form abandonment is enabled on a form.
	 *
	 * @since 1.0.0
	 * @param array $form_data
	 * @return bool
	 */
	public function has_form_abandonment( $form_data = array() ) {

		return !empty( $form_data['settings']['form_abandonment'] );
	}
}
new WPForms_Form_Abandonment;