<?php
/**
 * Javascript
 *
 * @package     CHP Advertising Theme Framework
 * @subpackage  javascript functions
 * @copyright   Copyright (c) 2013, CHP Advertising
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0 
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Load Scripts
 *
 * Enqueues all theme scripts
 *
 * @access      private
 * @since       1.0 
 * @return      void
*/

function chp_load_scripts() {

	/* -- Header Scripts */

	$in_footer = false;


	/* -- Footer Scripts -- */

	$in_footer = true;

	wp_enqueue_script( 'theme-plugins', THEME_JS . 'theme-plugins.js', array('jquery'), '1.0', $in_footer );
	wp_enqueue_script( 'theme-scripts', THEME_JS . 'theme-scripts.js', array('theme-plugins'), '1.0', $in_footer );
	wp_enqueue_script( 'theme-comment-validation', THEME_JS . 'theme-comment-validation.js', array('theme-plugins'), '1.0', $in_footer );

} add_action('wp_enqueue_scripts', 'chp_load_scripts');


/**
 * Load Admin Scripts
 *
 * Enqueues all admin scripts
 *
 * @access      private
 * @since       1.0 
 * @return      void
*/

function chp_load_admin_scripts() {

	$in_footer = true;

	wp_enqueue_script( 'theme-admin-scripts', THEME_JS . 'admin/theme-admin-scripts.js', array('jquery'), '1.0', $in_footer );

} add_action('admin_enqueue_scripts', 'chp_load_admin_scripts');



# END javascript.php
