<?php
/**
 * Pages
 *
 * @package     CHP Framework
 * @copyright   Copyright (c) 2013, CHP Advertising
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       2.0 
*/

// Exit if accessed directly
if ( ! defined('ABSPATH') ) exit;

/**
 * Post Exists
 *
 * Checks to see if a post exists by title. This function WILL return true for trashed posts.
 *
 * @since       2.0
 * @param       title
 * @return      boolean
*/

function chp_post_exists( $title ) {

    global $wpdb;
    return $wpdb->get_row("SELECT * FROM wp_posts WHERE post_title = '" . $title . "'", 'ARRAY_A');

}


/**
 * Sets up the default theme pages
 *
 * @since       2.0 
 * @return      null
*/

function chp_create_default_pages() {

    if ( get_option('chp-default-pages-created') == true )
        return false;

    $pages = array();

    // Home Page
    $pages['home'] = array(
        'post_title'     => 'Homepage',
        'post_content'   => '',
        'post_status'    => 'publish',
        'post_author'    => 1,
        'post_type'      => 'page',
        'comment_status' => 'closed'
    );

    // About Page
    $pages['about'] = array(
        'post_title'     => 'About',
        'post_content'   => '',
        'post_status'    => 'publish',
        'post_author'    => 1,
        'post_type'      => 'page',
        'comment_status' => 'closed'
    );

    // Contact Page
    $pages['contact'] = array(
        'post_title'     => 'Contact',
        'post_content'   => '',
        'post_status'    => 'publish',
        'post_author'    => 1,
        'post_type'      => 'page',
        'comment_status' => 'closed'
    );

    // Privacy Page
    $pages['privacy'] = array(
        'post_title'     => 'Privacy Policy',
        'post_content'   => '',
        'post_status'    => 'publish',
        'post_author'    => 1,
        'post_type'      => 'page',
        'comment_status' => 'closed'
    );

    // Terms Page
    $pages['terms'] = array(
        'post_title'     => 'Terms and Conditions',
        'post_content'   => '',
        'post_status'    => 'publish',
        'post_author'    => 1,
        'post_type'      => 'page',
        'comment_status' => 'closed'
    );

    if ( CHP_IS_BLOG ) {

        // Blog Page
        $pages['blog'] = array(
            'post_title'     => 'Blog',
            'post_content'   => '',
            'post_status'    => 'publish',
            'post_author'    => 1,
            'post_type'      => 'page',
            'comment_status' => 'closed'
        );

    }


    /*
     * Developer Hook ( can either modify what will be created, or turn off this functionality completely )
     */
    $pages = apply_filters('chp-default-pages', $pages );

    if ( $pages == false )
        return false;

    foreach ( $pages as $key => $page ) {

        if ( ! chp_post_exists($page['post_title']) )
            add_option( 'chp-' . $key . '-page', wp_insert_post($page) );
           
    }

    // Insert option into DB so that we know the pages have been created
    add_option('chp-default-pages-created', true );

} add_action('after_switch_theme', 'chp_create_default_pages');


# END pages.php
