<?php
/**
 * Login Page Functions
 *
 * @package     CHP Advertising Theme Framework
 * @subpackage  login functions
 * @copyright   Copyright (c) 2013, CHP Advertising
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;


/**
 * Login Logo
 *
 * Adds a custom logo to the login page
 *
 * @access      private
 * @since       1.0 
 * @return      string - the logo styling
*/

function chp_login_logo() {

	$logo = chp_get_option('logo');

	if ( $logo ) {

		echo '<style rel="chp-login-logo" type="text/css">';

			printf(
				'h1 a {
					background-image: url(%s) !important;
					background-size: auto !important;
					height: 130px !important;
				}',
				$logo
			);

		echo '</style>';

	}

} add_action( 'login_enqueue_scripts', 'chp_login_logo' );


/**
 * Login Logo Title
 *
 * Changes the login logo title to the site's title
 *
 * @access      private
 * @since       1.0 
 * @return      string - the logo title
*/

function chp_login_logo_title() {

	return get_bloginfo('name');

} add_filter( 'login_headertitle', 'chp_login_logo_title' );


/**
 * Login Logo Url
 *
 * Changes the login logo url to the site's url
 *
 * @access      private
 * @since       1.0 
 * @return      string - the logo url
*/

function chp_login_logo_url() {

	return get_bloginfo('url');

} add_filter( 'login_headerurl', 'chp_login_logo_url' );



# END login.php
