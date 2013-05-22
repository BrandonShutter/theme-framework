<?php
/**
 * Pages
 *
 * @package     CHP Advertising Theme Framework
 * @subpackage  page functions
 * @copyright   Copyright (c) 2013, CHP Advertising
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.1 
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Creates the default pages used with the theme
 *
 * @access      private
 * @since       1.1 
 * @return      string - the messages
*/

function chp_create_pages() {

	$pages = array();

	// Homepage
	$pages['homepage'] = array(
		'post_title'     => 'Homepage',
		'post_content'   => '',
		'post_status'    => 'publish',
		'post_author'    => 1,
		'post_type'      => 'page',
		'comment_status' => 'closed'
	);

	// About
	$pages['about'] = array(
		'post_title'     => 'About',
		'post_content'   => '',
		'post_status'    => 'publish',
		'post_author'    => 1,
		'post_type'      => 'page',
		'comment_status' => 'closed'
	);

	// Contact
	$pages['contact'] = array(
		'post_title'     => 'Contact',
		'post_content'   => '',
		'post_status'    => 'publish',
		'post_author'    => 1,
		'post_type'      => 'page',
		'comment_status' => 'closed'
	);

	// Privacy Policy
	$pages['privacy-policy'] = array(
		'post_title'     => 'Privacy Policy',
		'post_content'   => '',
		'post_status'    => 'publish',
		'post_author'    => 1,
		'post_type'      => 'page',
		'comment_status' => 'closed'
	);

	// Terms and Conditions
	$pages['terms-and-conditions'] = array(
		'post_title'     => 'Terms and Conditions',
		'post_content'   => '',
		'post_status'    => 'publish',
		'post_author'    => 1,
		'post_type'      => 'page',
		'comment_status' => 'closed'
	);

	// 404 Error
	$pages['404-error'] = array(
		'post_title'     => '404 - Page Not Found',
		'post_name'      => '404-error',
		'post_content'   => 'Unfortunately the page you were looking for could not be found. Please double check the url you have entered in, and then try loading the page again.',
		'post_status'    => 'publish',
		'post_author'    => 1,
		'post_type'      => 'page',
		'comment_status' => 'closed'
	);

	/*
	 * Filter Hook - Can be used by developers to extend upon or remove pages
	 */

	$pages = apply_filters( 'chp-pages', $pages );


	// Create each page, if they don't already exist

	foreach ( $pages as $page ) {

		if ( ! chp_post_exists($page['post_title']) )
			wp_insert_post( $page );

	}

}

add_action('after_switch_theme', 'chp_create_pages', 10);


/**
 * Post Exists
 *
 * Checks to see if a post exists by title
 *
 * @access      public
 * @since       1.1
 * @param       title
 * @return      boolean
*/

function chp_post_exists( $title ) {

	global $wpdb;
	return $wpdb->get_row("SELECT * FROM wp_posts WHERE post_title = '" . $title . "'", 'ARRAY_A');

}


# END pages.php
