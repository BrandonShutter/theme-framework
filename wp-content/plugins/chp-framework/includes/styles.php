<?php
/**
 * Styling Functions
 *
 * @package     CHP Framework
 * @copyright   Copyright (c) 2013, CHP Advertising
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0  
*/

// Exit if accessed directly
if ( ! defined('ABSPATH') ) exit;

/**
 * Enqueues all stylesheets
 *
 * @since       1.0
 * @return      null
*/

function chp_enqueue_styles() {

	/* ---------------------
	 * Plugin Styles
	--------------------- */

	wp_enqueue_style('chp-reset',  CHP_CSS . 'reset.css');

	/* ---------------------
	 * Theme Styles
	--------------------- */

	if ( file_exists( get_template_directory() . '/media/css/fonts.css' ) )
		wp_enqueue_style('chp-theme-fonts', THEME_CSS . 'fonts.css');

	wp_enqueue_style('chp-theme-css', THEME_BASE . '/style.css');

	if ( file_exists( get_template_directory() . '/media/css/responsive.css' ) )
		wp_enqueue_style('chp-theme-responsive', THEME_CSS . 'responsive.css');

} add_action( 'wp_enqueue_scripts', 'chp_enqueue_styles' );


/**
 * Enqueues all conditional styles
 *
 * @since       1.0
 * @return      null
*/

function chp_enqueue_conditional_styles() {

	?>

	<?php if ( file_exists( get_template_directory() . '/media/css/ie.css') ): ?>

	<!--[if IE]>
		<link rel="stylesheet" href="<?php echo THEME_CSS . 'ie.css' ?>">
	<![endif]-->

	<?php endif; ?>

	<?php if ( file_exists( get_template_directory() . '/media/css/ie8.css') ): ?>
	
	<!--[if lt IE 9]>
		<link rel="stylesheet" href="<?php echo THEME_CSS . 'ie8.css' ?>">
	<![endif]-->

	<?php endif; ?>

	<?php

	do_action('chp-conditional-styles');

} add_action( 'wp_head', 'chp_enqueue_conditional_styles' );


/**
 * Outputs the theme's custom css if set in the theme options panel
 *
 * @since       1.0
 * @return      string
*/

function chp_custom_css() {

	$custom_css = chp_option('custom-css');
	
	if ( $custom_css ):

		$output  = '<!-- Custom CSS -->';
		$output .= '<style>';
		$output .= $custom_css;
		$output .= '</style>';

		echo $output;

	endif;

}


# END styles.php
