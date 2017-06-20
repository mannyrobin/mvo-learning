<?php
/**
 * Helper Functions
 *
 * @package     PopMake\ExitIntentPopups\Functions
 * @since       1.0.0
 */


// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Returns the exit intent meta of a popup.
 *
 * @since 1.0
 *
 * @param int $popup_id ID number of the popup to retrieve a exit intent meta for
 * @param null $key
 * @param null $default
 *
 * @return mixed array|string of the popup exit intent meta
 */
function popmake_get_popup_exit_intent( $popup_id = null, $key = null, $default = null ) {
	return popmake_get_popup_meta( 'exit_intent', $popup_id, $key, $default );
}