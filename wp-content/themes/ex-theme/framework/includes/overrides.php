<?php
/**
 * Overrides
 *
 * @package     CHP Advertising Theme Framework
 * @subpackage  plugin override functions
 * @copyright   Copyright (c) 2013, CHP Advertising
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.1 
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;



/*
 * WPCF7 Overrides
 */

if ( defined('WPCF7_VERSION') ):

/**
 * Overrides the default form messages for the WPCF7 Plugin
 *
 * @access      private
 * @since       1.1 
 * @return      string - the messages
*/

function chp_override_wpcf7_messages( $messages ) {

	$messages['mail_sent_ok']['default']      =  __( "Your message has been sent successfully. We'll be getting back to you shortly!"                        , 'wpcf7' );
	$messages['mail_sent_ng']['default']      =  __( "Unfortunately your email was unable to be sent. Please try again shortly."                             , 'wpcf7' );
	$messages['validation_error']['default']  =  __( "We have found some errors with what you have submitted. Please double check everything and try again." , 'wpcf7' );
	$messages['spam']['default']              =  __( "Unfortunately your message was considered to be spam. Please edit your message and try again."         , 'wpcf7' );

	return apply_filters( 'chp-wpcf7-message', $messages );

}

add_filter( 'wpcf7_messages', 'chp_override_wpcf7_messages' );


function chp_override_wpcf7_enqueues() {

	global $pagename;

	if ( isset($pagename) && $pagename == 'contact' ) {

		wpcf7_enqueue_scripts();
		wpcf7_enqueue_styles();

	}

}

add_action( 'wp_enqueue_scripts', 'chp_override_wpcf7_enqueues');


endif; // End WPCF7 Overrides





# END overrides.php
