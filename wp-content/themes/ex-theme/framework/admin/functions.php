<?php
/**
 * Admin Functions
 *
 * @package     CHP Advertising Theme Framework
 * @subpackage  admin general functions
 * @copyright   Copyright (c) 2013, CHP Advertising
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0 
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;


/**
 * User Has Role 
 *
 * Checks if a particular user has a role. 
 *
 * @access      private
 * @since       1.0
 * @param       string - the role
 * @param       int - The ID of a user. Defaults to the current user
 * @return      bool
*/

function chp_user_has_role( $role, $user_id = null ) {
 
    if ( is_numeric( $user_id ) )
		$user = get_userdata( $user_id );
    else
        $user = wp_get_current_user();
 
    if ( empty( $user ) )
		return false;
 
    return in_array( $role, (array) $user->roles );
}


/**
 * Clean Admin Menu
 *
 * Removes unnecessary menu items from the WP admin menu
 *
 * @access      private
 * @since       1.0 
 * @return      void
*/

function chp_clean_admin_menu() {

	// Remove "Links" menu item
	remove_menu_page('link-manager.php');
	
	if ( ! chp_user_has_role('administrator') ) {

		// Remove "Tools" menu item
		remove_menu_page('tools.php');

		// Remove "Settings" menu item
		remove_menu_page('options-general.php');

	}

	do_action('chp-clean-admin-menu');

} add_action('admin_menu', 'chp_clean_admin_menu');


/**
 * Clean Admin Dashboard
 *
 * Removes unnecessary widgets from the WP admin dashboard
 *
 * @access      private
 * @since       1.0
 * @return      void
*/

function chp_clean_admin_dashboard() {

	// Remove Incoming Links Widget
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');

	// Remove Plugins Widget
    remove_meta_box('dashboard_plugins', 'dashboard', 'core');

    // Remove WordPress Blog Widget
    remove_meta_box('dashboard_primary', 'dashboard', 'core');

    // Remove WordPress News Widget
    remove_meta_box('dashboard_secondary', 'dashboard', 'core');


    do_action('chp-clean-admin-dashboard');

} add_action('admin_menu', 'chp_clean_admin_dashboard');




# END functions.php
