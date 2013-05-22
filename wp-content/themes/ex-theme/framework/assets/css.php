<?php
/**
 * CSS
 *
 * @package     CHP Advertising Theme Framework
 * @subpackage  css functions
 * @copyright   Copyright (c) 2013, CHP Advertising
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0 
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Load Stylesheets
 *
 * Enqueues all theme stylesheets
 *
 * @access      private
 * @since       1.0 
 * @return      void
*/

function chp_load_stylesheets() {

	wp_enqueue_style('theme-styling', THEME_BASE . '/style.css');

} add_action('wp_enqueue_scripts', 'chp_load_stylesheets');




# END css.php
