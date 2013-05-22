<?php
/**
 * Admin Restrict
 *
 * @package     CHP Framework
 * @copyright   Copyright (c) 2013, CHP Advertising
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0 
*/

// Exit if accessed directly
if ( ! defined('ABSPATH') ) exit;

/**
 * Restricts certain pages for those who aren't an admin
 *
 * @since       1.0
 * @return      void
*/

function chp_restrict_admin_pages( $menu_items ) {

    if ( current_user_can('administrator') )
        return $menu_items;

    // Remove 'Tools' menu item
    $menu_items[] = 'tools.php';

    // Remove 'Theme Editor' menu item
    $menu_items[] = array(
        'parent' => 'themes.php',
        'id'     => 'theme-editor.php'
    );  

    // Remove 'Plugin Editor' menu item
    $menu_items[] = array(
        'parent' => 'plugins.php',
        'id'     => 'plugin-editor.php'
    );

    // Remove 'Media Options' menu item
    $menu_items[] = array(
        'parent' => 'options-general.php',
        'id'     => 'options-media.php'
    );

    // Remove 'Permalink Options' menu item
    $menu_items[] = array(
        'parent' => 'options-general.php',
        'id'     => 'options-permalink.php'
    );

    // Remove 'Option Tree' menu item
    $menu_items[] = 'ot-settings';

    // Remove 'Limit Login Attempts' menu item
    $menu_items[] = array(
        'parent' => 'options-general.php',
        'id'     => 'limit-login-attempts'
    );

    return $menu_items;

} add_filter( 'chp-unregister-menu-items', 'chp_restrict_admin_pages' );


/**
 * Restricts certain pages for those who aren't an admin
 *
 * @since       1.0
 * @return      void
*/

function chp_restrict_admin_bar_links( $links ) {

    if ( current_user_can('administrator') )
        return $links;

    // Remove 'Performance' tab for W3 Total Cache
    $links[] = 'w3tc';

    return $links;

} add_filter( 'chp-unregister-adminbar-links', 'chp_restrict_admin_bar_links' );


# END restrict.php
