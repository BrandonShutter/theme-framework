<?php
/**
 * User
 *
 * @package     CHP Framework
 * @copyright   Copyright (c) 2013, CHP Advertising
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0 
*/

// Exit if accessed directly
if ( ! defined('ABSPATH') ) exit;

/**
 * Creates the 'Site Owner' role, which purpose is to limit the capabalities of the site owner ( really for their own benefit )  
 *
 * @since       1.0 
 * @return      void
*/

function chp_create_site_owner() {

	if ( get_option('chp-site-owner-created') == true )
		return false;

	// Create a "Site Owner" Role

	add_role(
		'site-owner',
		'Site Owner',
		apply_filters( 'chp-site-owner-caps', array(

			'delete_pages'           => true,
			'delete_posts'           => true,
			'delete_others_pages'    => true,
			'delete_others_posts'    => true,
			'delete_private_pages'   => true,
			'delete_private_posts'   => true,
			'delete_published_pages' => true,
			'delete_published_posts' => true,
			'edit_dashboard'         => true,
			'edit_pages'             => true,
			'edit_posts'             => true,
			'edit_others_pages'      => true,
			'edit_others_posts'      => true,
			'edit_private_pages'     => true,
			'edit_private_posts'     => true,
			'edit_published_pages'   => true,
			'edit_published_posts'   => true,
			'edit_theme_options'     => true,
			'list_users'             => true,
			'manage_categories'      => true,
			'manage_links'           => true,
			'manage_options'         => true,
			'moderate_comments'      => true,
			'edit_comments'          => true,
			'promote_users'          => true,
			'publish_pages'          => true,
			'publish_posts'          => true,
			'read_private_pages'     => true,
			'read_private_posts'     => true,
			'read'                   => true,
			'remove_users'           => true,
			'unfiltered_upload'      => true,
			'upload_files'           => true,
			'update_core'            => true,
			'install_plugins'        => true,
			'activate_plugins'       => true,
			'update_plugins'         => true,
			'edit_plugins'           => true,
			'edit_users'             => true,
			'create_users'           => true,
			'delete_users'           => true,
			'unfiltered_html'        => true

		))
	);

	// Create the Site Owner User

	wp_insert_user( array(

		'user_login' => 'site-owner',
		'user_pass'  => 'password',
		'user_url'   => get_bloginfo('url'),
		'user_email' => get_bloginfo('admin_email'),
		'role'       => 'site-owner'

	));

	// Insert option into DB so that we know the owner has been created
	add_option('chp-site-owner-created', true );

} add_action('after_switch_theme', 'chp_create_site_owner', 10 );


# END user.php
