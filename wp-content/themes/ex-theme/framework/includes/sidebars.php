<?php
/**
 * Sidebars
 *
 * @package     CHP Advertising Theme Framework
 * @subpackage  sidebar functions
 * @copyright   Copyright (c) 2013, CHP Advertising
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0 
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;


/**
 * Register Sidebars
 *
 * Registers theme sidebars
 *
 * @access      private
 * @since       1.0 
 * @return      void
*/

function chp_register_sidebars() {

	$sidebar         = apply_filters('chp-sidebar', register_sidebar( array(
		'name'          => 'Sidebar',
		'description'   => 'This sidebar is displayed on most pages by default.',
		'before_widget' => '<section class="widget">',
		'after_widget'  => '</div></section>',
		'before_title'  => '<div class="widget-heading"><h6>',
		'after_title'   => '</h6></div><div class="widget-content">'
	)));

	$blog_sidebar    = apply_filters('chp-blog-sidebar', register_sidebar( array(
		'name'          => 'Blog Sidebar',
		'description'   => 'This sidebar is displayed on all blog pages.',
		'before_widget' => '<section class="widget">',
		'after_widget'  => '</div></section>',
		'before_title'  => '<div class="widget-heading"><h6>',
		'after_title'   => '</h6></div><div class="widget-content">'
	)));

	$contact_sidebar = apply_filters('chp-contact-sidebar', register_sidebar( array(
		'name'          => 'Contact Sidebar',
		'description'   => 'This sidebar is displayed on the contact page.',
		'before_widget' => '<section class="widget">',
		'after_widget'  => '</div></section>',
		'before_title'  => '<div class="widget-heading"><h6>',
		'after_title'   => '</h6></div><div class="widget-content">'
	)));

	$footer_section  = apply_filters('chp-footer-section', register_sidebar( array(
		'name'          => 'Footer Section',
		'description'   => 'Widgets added to this section will be displayed in the footer.',
		'before_widget' => '<section class="widget">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget-heading"><h6>',
		'after_title'   => '</h6></div><div class="widget-content">'
	)));

	/*
     * Action Hook - Can be used to add additional sidebars to the theme
     */

	do_action('chp-register-sidebars');

}

add_action('widgets_init', 'chp_register_sidebars');




# END sidebars.php
