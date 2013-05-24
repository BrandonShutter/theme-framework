<?php
/**
 * Admin Cleanup
 *
 * @package     CHP Framework
 * @copyright   Copyright (c) 2013, CHP Advertising
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       2.0 
*/

// Exit if accessed directly
if ( ! defined('ABSPATH') ) exit;

/**
 * Admin General Cleanup
 *
 * Removes unnecessary ( in our case ) elements from the admin panel
 *
 * @since       2.0
 * @return      void
*/

function chp_admin_general_cleanup() {

    $menu_items = array(

        'link-manager.php',  // Remove "Links" menu item

        // Remove 'FAQ' from W3 Total Cache
        array(
            'parent' => 'w3tc_dashboard',
            'id'     => 'w3tc_faq'
        ),

        // Remove 'Monitoring' from W3 Total Cache
        array(
            'parent' => 'w3tc_dashboard',
            'id'     => 'w3tc_monitoring'
        ),

        // Remove 'Support' from W3 Total Cache
        array(
            'parent' => 'w3tc_dashboard',
            'id'     => 'w3tc_support'
        ),

        // Remove 'Install' from W3 Total Cache
        array(
            'parent' => 'w3tc_dashboard',
            'id'     => 'w3tc_install'
        ),

        // Remove 'About' from W3 Total Cache
        array(
            'parent' => 'w3tc_dashboard',
            'id'     => 'w3tc_about'
        ),

        // Remove 'CDN' from W3 Total Cache
        array(
            'parent' => 'w3tc_dashboard',
            'id'     => 'w3tc_cdn'
        ),

        // Remove 'Referrer' from W3 Total Cache
        array(
            'parent' => 'w3tc_dashboard',
            'id'     => 'w3tc_referrer'
        ),

        // Remove 'User Agent' from W3 Total Cache
        array(
            'parent' => 'w3tc_dashboard',
            'id'     => 'w3tc_mobile'
        )

    );

    if ( ! CHP_IS_BLOG ) {

        $blog_items = array(
            'upload.php',        // Remove "Media" menu item
            'edit.php',          // Remove "Posts" menu item
            'edit-comments.php'  // Remove "Comments" menu item
        );

        $menu_items = array_merge( $menu_items, $blog_items );

    }

    $menu_items = apply_filters('chp-unregister-menu-items', $menu_items );

    foreach ( $menu_items as $item ) {

        if ( is_array($item) )
            remove_submenu_page( $item['parent'], $item['id'] );
        else
            remove_menu_page( $item );

    }

    $metaboxes = apply_filters('chp-unregister-metaboxes', array(
       'commentsdiv',        // Remove Comments
       'commentstatusdiv',   // Remove Comments Status
       'authordiv',          // Remove Author 
       'postcustom',         // Remove Custom Fields Metabox
       'slugdiv'             // Remove Slug Metabox
    ));

    foreach ( $metaboxes as $metabox )
        remove_meta_box( $metabox, 'page', 'normal' );

} add_action( 'admin_menu', 'chp_admin_general_cleanup', 30 );


/**
 * Admin Dashboard Cleanup
 *
 * Removes unnecessary widgets from the WP Dashboard
 *
 * @since       2.0
 * @return      void
*/

function chp_admin_dashboard_cleanup() {

    $metaboxes = array(

        // Remove Incoming Links Widget
        array(
            'id'      => 'dashboard_incoming_links', 
            'context' => 'normal'
        ),

        // Remove Plugins Widget
        array(
            'id'      => 'dashboard_plugins',
            'context' => 'normal'
        ),

        // Remove WordPress Blog Widget
        array(
            'id'      => 'dashboard_primary',
            'context' => 'side'
        ),

        // Remove WordPress News Widget
        array(
            'id'      => 'dashboard_secondary',
            'context' => 'side'
        ),

        // Remove QuickPress Widget
        array(
            'id'      => 'dashboard_quick_press',
            'context' => 'side'
        )

    );


    if ( ! CHP_IS_BLOG ) {

        $blog_metaboxes = array(

            // Remove Recent Drafts Widget
            array(
                'id'      => 'dashboard_recent_drafts',
                'context' => 'side'
            ),

            // Recent Recent Comments Widgets
            array(
                'id'      => 'dashboard_recent_comments',
                'context' => 'normal'
            )

        );

        $metaboxes = array_merge( $metaboxes, $blog_metaboxes );

    }

    $metaboxes = apply_filters('chp-unregister-dashboard-metaboxes', $metaboxes );

    foreach ( $metaboxes as $metabox )
        remove_meta_box( $metabox['id'], 'dashboard', $metabox['context'] );

} add_action( 'wp_dashboard_setup', 'chp_admin_dashboard_cleanup' );


/**
 * Removes the unnessary ( in our case ) WP Widgets
 *
 * @since       2.0 
 * @return      void
*/

function chp_admin_widgets_cleanup() {

    $widgets = apply_filters('chp-unregister-widgets', array(
        'WP_Widget_Pages',
        'WP_Widget_Calendar',
        'WP_Widget_Archives',
        'WP_Widget_Links',
        'WP_Widget_Categories',
        'WP_Widget_Recent_Posts',
        'WP_Widget_Search',
        'WP_Widget_Tag_Cloud',
        'WP_Widget_Meta',
        'WP_Widget_RSS',
        'WP_Widget_Recent_Comments'
    ));

    foreach ( $widgets as $widget )
        unregister_widget( $widget );

} add_action( 'widgets_init', 'chp_admin_widgets_cleanup', 100 );


/**
 * Removes unnessary ( in our case ) links from the WP Admin Bar
 *
 * @since       2.0 
 * @return      void
*/

function chp_admin_bar_cleanup() {

    global $wp_admin_bar;

    $links = array(
        'updates',    // Remove the updates link
        'new-content' // Remove the content link
    );

    if ( ! CHP_IS_BLOG )
        $links[] = 'comments';

    $links = apply_filters('chp-unregister-adminbar-links', $links );

    foreach ( $links as $link )
        $wp_admin_bar->remove_menu( $link );

} add_action( 'wp_before_admin_bar_render', 'chp_admin_bar_cleanup' );


# END cleanup.php
