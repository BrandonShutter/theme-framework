<?php
/**
 * Script Functions
 *
 * @package     CHP Framework
 * @copyright   Copyright (c) 2013, CHP Advertising
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0  
*/

// Exit if accessed directly
if ( ! defined('ABSPATH') ) exit;

/**
 * Enqueues all framework scripts
 *
 * @since       1.0
 * @return      null
*/

function chp_enqueue_scripts() {

	global $post;

	$in_footer = true;

	/* ---------------------
	 * Plugin Scripts
	--------------------- */

	wp_register_script( 'pretty-photo', CHP_JS . 'plugins/jquery-prettyphoto.min.js', array('jquery'), '3.1.5', $in_footer );

	if ( CHP_IS_RESPONSIVE ) {
		wp_register_script( 'flexmenu', CHP_JS . 'plugins/responsive/jquery-flexmenu.min.js', array('jquery'), '1.1', $in_footer );
		wp_register_script( 'flexslider', CHP_JS . 'plugins/responsive/jquery-flexslider.min.js', array('jquery'), '2.1.1', $in_footer );
	}
	
	wp_enqueue_script( 'jquery-color', CHP_JS . 'plugins/jquery-color.min.js', array('jquery'), '2.1.1', $in_footer );
	wp_enqueue_script( 'chp-scripts', CHP_JS . 'chp-scripts.js', array('jquery'), '1.0', $in_footer );

	if ( is_single() )
		wp_enqueue_script( 'chp-comment-validation', CHP_JS . 'chp-comment-validation.js', '1.0', $in_footer );

	if ( isset($post) && $post->ID == get_option('chp-contact-page') ) {
		wpcf7_enqueue_scripts();
		wpcf7_enqueue_styles();
	}

	/* ---------------------
	 * Theme Scripts
	--------------------- */

	wp_enqueue_script( 'theme-scripts', THEME_JS . 'theme-scripts.js', array('jquery'), '1.0', $in_footer );

	if ( file_exists( get_template_directory() . '/media/js/responsive.js' ) )
		wp_enqueue_script( 'theme-responsive', THEME_JS . 'responsive.js', array('jquery'), '1.0', $in_footer );

} add_action( 'wp_enqueue_scripts', 'chp_enqueue_scripts' );


/**
 * Enqueues all conditional scripts
 *
 * @since       1.0
 * @return      null
*/

function chp_enqueue_conditional_scripts() {

	?>

	<!--[if lt IE 9]>
		<script type="text/javascript" src="<?php echo CHP_JS ?>ie-specific/html5.js"></script>
		<script type="text/javascript" src="<?php echo CHP_JS ?>ie-specific/selectivizr.min.js"></script>
		<script type="text/javascript" src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
	<![endif]-->

	<?php

	do_action('chp-conditional-scripts');

} add_action( 'wp_head', 'chp_enqueue_conditional_scripts' );


/**
 * Outputs the theme's google analytics if set in the theme options panel
 *
 * @since       1.0
 * @return      string
*/

function chp_analytics() {

	$analytics = chp_option('google-analytics');
	
	if ( $analytics ):

		$output  = '<!-- Google Analytics Tracking Code -->';
		$output .= '<script type="text/javascript">';
		$output .= $analytics;
		$output .= '</script>';

		echo $output;

	endif;

}


# END scripts.php
