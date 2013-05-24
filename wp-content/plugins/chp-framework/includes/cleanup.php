<?php 
/**
 * Frontend Cleanup Functions
 *
 * @package     CHP Framework
 * @copyright   Copyright (c) 2013, CHP Advertising
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       2.0 
*/

// Exit if accessed directly
if ( ! defined('ABSPATH') ) exit;

/**
 * Removes default WP meta from header
 *
 * @since       2.0
 * @return      void
*/

function chp_wp_head_cleanup() {

	remove_action( 'wp_head', 'feed_links_extra', 3 );                     // Displays the links to the extra feeds such as category feeds
	remove_action( 'wp_head', 'feed_links', 2 );                           // Displays the links to the general feeds: Post and Comment Feed
	remove_action( 'wp_head', 'rsd_link' );                                // Displays the link to the Really Simple Discovery service endpoint, EditURI link
	remove_action( 'wp_head', 'wlwmanifest_link' );                        // Displays the link to the Windows Live Writer manifest file.
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );  // Displays relational links for the posts adjacent to the current post.
	remove_action( 'wp_head', 'wp_generator' );                            // Displays the XHTML generator that is generated on the wp_head hook, WP version
	remove_action( 'wp_head', 'index_rel_link' );                          // Displays Index link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );             // Displays Prev link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );              // Displays Start link

} add_action('init', 'chp_wp_head_cleanup');


# END cleanup.php
