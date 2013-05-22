<?php
/**
 * Settings
 *
 * @package     CHP Framework
 * @copyright   Copyright (c) 2013, CHP Advertising
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0  
*/

// Exit if accessed directly
if ( ! defined('ABSPATH') ) exit;

/**
 * Sets up the default framework options
 *
 * @since       1.0
 * @return      null
*/

function chp_default_settings() {

	if ( get_option('chp-default-settings-set') == true )
		return false;

	update_option( 'date_format', 'M j, Y' );
	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', get_option('chp-home-page') );

	if ( CHP_IS_BLOG )
		update_option( 'page_for_posts', get_option('chp-blog-page') );

	update_option( 'blog_public', true );
	update_option( 'uploads_use_yearmonth_folders', false );
	update_option( 'permalink_structure', '/%postname%/');

	// Import OT Settings
	update_option('option_tree_settings',
		unserialize( ot_decode( file_get_contents(CHP_BASE . 'ot-settings.rtf') )
	));

	// Delete OT Import file
	unlink( CHP_BASE . 'ot-settings.rtf' );

	// Contact Form 7 Settings


	// W3 Total Cache Settings
	
	// Insert option into DB so that we know the settings have been set
	add_option('chp-default-settings-set');

} add_action( 'after_switch_theme', 'chp_default_settings' );


/**
 * Sets the default user messages for WPCF7
 *
 * @since       1.0
 * @return      string - the messages
*/

function chp_wpcf7_default_messages( $messages ) {

	$messages['mail_sent_ok']['default']      =  __( "Your message has been sent successfully. We'll be getting back to you shortly!"                        , 'wpcf7' );
	$messages['mail_sent_ng']['default']      =  __( "Unfortunately your email was unable to be sent. Please try again shortly."                             , 'wpcf7' );
	$messages['validation_error']['default']  =  __( "We have found some errors with what you have submitted. Please double check everything and try again." , 'wpcf7' );
	$messages['spam']['default']              =  __( "Unfortunately your message was considered to be spam. Please edit your message and try again."         , 'wpcf7' );

	return apply_filters( 'chp-wpcf7-messages', $messages );

}

add_filter( 'wpcf7_messages', 'chp_wpcf7_default_messages' );


/**
 * Option
 *
 * Returns, or echos the option key provided if it was set in the backend
 *
 * @since       1.0
 * @param       $key - option name
 * @param       $echo - whether or not to echo the data retrieved
 * @return      string || boolean
*/

function chp_option( $key, $echo = true ) {

	$options = get_option('option_tree');

	$key = str_replace('-', '_', $key );

	if ( ! array_key_exists( $key, $options ) ) 
		return false;

	$option = $options[ $key ];

	if ( $echo == true )
		echo $option;
	else
		return $option;

}


# END settings.php
