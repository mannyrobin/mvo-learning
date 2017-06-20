<?php

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists( 'PopMake_Exit_Intent_Popups_Admin_Popup_Metabox_Fields' ) ) {

	/**
	 * Main PopMake_Exit_Intent_Popups_Admin_Popup_Metabox_Fields class
	 *
	 * @since       1.0.0
	 */
	class PopMake_Exit_Intent_Popups_Admin_Popup_Metabox_Fields {

		public function enabled( $popup_id ) { ?>
			<tr>
				<th scope="row"><?php _e( 'Enable Exit Intent Popups', 'popup-maker-exit-intent-popups' );?></th>
				<td>
					<input type="checkbox" value="true" name="popup_exit_intent_enabled" id="popup_exit_intent_enabled" <?php checked( popmake_get_popup_exit_intent( $popup_id, 'enabled' ), 'true' ); ?>/>
					<label for="popup_exit_intent_enabled" class="description"><?php _e( 'Checking this will cause popup to open automatically.', 'popup-maker-exit-intent-popups' );?></label>
				</td>
			</tr><?php
		}

		public function type( $popup_id ) { ?>
			<tr class="exit-intent-enabled">
				<th scope="row">
					<label for="popup_exit_intent_type"><?php _e( 'Type', 'popup-maker-exit-intent-popups' );?></label>
				</th>
				<td>
					<select name="popup_exit_intent_type" id="popup_exit_intent_type">
					<?php foreach( apply_filters( 'popmake_eip_exit_popup_type_options', array() ) as $option => $value ) : ?>
						<option
							value="<?php echo $value;?>"
							<?php selected( $value, popmake_get_popup_exit_intent( $popup_id, 'type' ) ); ?>
						><?php echo $option;?></option>
					<?php endforeach ?>
					</select>
					<p class="description"><?php _e( 'Choose the type of exit prevention to use.', 'popup-maker-exit-intent-popups' ); ?></p>
				</td>
			</tr><?php
		}

		public function top_sensitivity( $popup_id ) {
			$top_sensitivity = popmake_get_popup_exit_intent( $popup_id, 'top_sensitivity' );
			if( ! $top_sensitivity ) {
				$top_sensitivity = 10;
			} ?>
			<tr class="exit-intent-enabled soft-only">
			<th scope="row">
				<label for="popup_exit_intent_top_sensitivity"><?php _e( 'Top Sensitivity', 'popup-maker-exit-intent-popups' );?></label>
			</th>
			<td>
				<input type="text" readonly
				       value="<?php esc_attr_e( $top_sensitivity ); ?>"
				       name="popup_exit_intent_top_sensitivity"
				       id="popup_exit_intent_top_sensitivity"
				       class="popmake-range-manual"
				       step="<?php esc_html_e( apply_filters( 'popup_exit_intent_top_sensitivity', 1 ) ); ?>"
				       min="<?php esc_html_e( apply_filters( 'popup_exit_intent_top_sensitivity', 1 ) ); ?>"
				       max="<?php esc_html_e( apply_filters( 'popup_exit_intent_top_sensitivity', 50 ) ); ?>"
					/>
				<span class="range-value-unit regular-text">px</span>
				<p class="description"><?php _e( 'This defines the distance from the top of the browser window where the users mouse movement is detected.', 'popup-maker-exit-intent-popups' ); ?></p>
			</td>
			</tr><?php
		}

		public function delay_sensitivity( $popup_id ) {
			$delay_sensitivity = popmake_get_popup_exit_intent( $popup_id, 'delay_sensitivity' );
			if( ! $delay_sensitivity ) {
				$delay_sensitivity = 350;
			} ?>
			<tr class="exit-intent-enabled soft-only">
			<th scope="row">
				<label for="popup_exit_intent_delay_sensitivity"><?php _e( 'False Positive Delay', 'popup-maker-exit-intent-popups' ); ?></label>
			</th>
			<td>
				<input type="text" readonly
				       value="<?php esc_attr_e( $delay_sensitivity ); ?>"
				       name="popup_exit_intent_delay_sensitivity"
				       id="popup_exit_intent_delay_sensitivity"
				       class="popmake-range-manual"
				       step="<?php esc_html_e( apply_filters( 'popup_exit_intent_delay_sensitivity', 25 ) );?>"
				       min="<?php esc_html_e( apply_filters( 'popup_exit_intent_delay_sensitivity', 100 ) );?>"
				       max="<?php esc_html_e( apply_filters( 'popup_exit_intent_delay_sensitivity', 750 ) );?>"
					/>
				<span class="range-value-unit regular-text">ms</span>
				<p class="description"><?php _e( 'This defines the delay used for false positive detection. A higher value reduces false positives, but increases chances of not opening in time.', 'popup-maker-exit-intent-popups' ); ?></p>
			</td>
			</tr><?php
		}

		public function hard_message( $popup_id ) { ?>
			<tr class="exit-intent-enabled alert-only hard-only">
				<th scope="row">
					<label for="popup_exit_intent_hard_message"><?php _e( 'Prompt Message', 'popup-maker-exit-intent-popups' );?></label>
				</th>
				<td>
					<input type="text" class="regular-text" name="popup_exit_intent_hard_message" id="popup_exit_intent_hard_message" value="<?php esc_attr_e( popmake_get_popup_exit_intent( $popup_id, 'hard_message' ) ); ?>"/>
					<p class="description"><?php _e( 'Enter the message displayed in the interrupt prompt.', 'popup-maker-exit-intent-popups' )?></p>
				</td>
			</tr><?php
		}


		public function cookie_trigger( $popup_id ) { ?>
			<tr class="exit-intent-enabled">
				<th scope="row">
					<label for="popup_exit_intent_cookie_trigger"><?php _e( 'Cookie Trigger', 'popup-maker-exit-intent-popups' );?></label>
				</th>
				<td>
					<select name="popup_exit_intent_cookie_trigger" id="popup_exit_intent_cookie_trigger">
					<?php foreach( apply_filters( 'popmake_eip_cookie_trigger_options', array() ) as $option => $value ) : ?>
						<option
							value="<?php echo $value;?>"
							<?php selected( $value, popmake_get_popup_exit_intent( $popup_id, 'cookie_trigger' ) ); ?>
						><?php echo $option;?></option>
					<?php endforeach ?>
					</select>
					<p class="description"><?php _e( 'When do you want to create the cookie.', 'popup-maker-exit-intent-popups' )?></p>
				</td>
			</tr><?php
		}


		public function cookie_time( $popup_id ) { ?>
			<tr class="exit-intent-enabled cookie-enabled">
				<th scope="row">
					<label for="popup_exit_intent_cookie_time"><?php _e( 'Cookie Time', 'popup-maker-exit-intent-popups' );?></label>
				</th>
				<td>
					<input type="text" class="regular-text" name="popup_exit_intent_cookie_time" id="popup_exit_intent_cookie_time" value="<?php esc_attr_e( popmake_get_popup_exit_intent( $popup_id, 'cookie_time' ) ); ?>"/>
					<p class="description"><?php _e( 'Enter a plain english time before cookie expires. <br/>Example "364 days 23 hours 59 minutes 59 seconds" will reset just before 1 year exactly.', 'popup-maker-exit-intent-popups' ); ?></p>
				</td>
			</tr><?php
		}


		public function cookie_path( $popup_id ) { ?>
			<tr class="exit-intent-enabled cookie-enabled">
				<th scope="row"><?php _e( 'Sitewide Cookie', 'popup-maker-exit-intent-popups' ); ?></th>
				<td>
					<input type="checkbox" value="/" name="popup_exit_intent_cookie_path" id="popup_exit_intent_cookie_path" <?php checked( popmake_get_popup_exit_intent( $popup_id, 'cookie_path' ), '/' ); ?>/>
					<label for="popup_exit_intent_cookie_path" class="description"><?php _e( 'This will prevent the popup from opening on any page until the cookie expires.', 'popup-maker-exit-intent-popups' ); ?></label>
				</td>
			</tr><?php
		}


		public function cookie_key( $popup_id ) { ?>
			<tr class="exit-intent-enabled cookie-enabled">
				<th scope="row">
					<label for="popup_exit_intent_cookie_key"><?php _e( 'Cookie Key', 'popup-maker-exit-intent-popups' ); ?></label>
				<td>
					<input type="text" value="<?php esc_attr_e( popmake_get_popup_exit_intent( $popup_id, 'cookie_key' ) ); ?>" name="popup_exit_intent_cookie_key" id="popup_exit_intent_cookie_key" /><button type="button" class="popmake-reset-exit-intent-cookie-key popmake-reset-cookie-key button button-primary large-button"></button>
					<p class="description"><?php _e( 'This changes the key used when setting and checking cookies. Resetting this will cause all existing cookies to be invalid.', 'popup-maker-exit-intent-popups' ); ?></p>
				</td>
			</tr><?php
		}

    }
} // End if class_exists check