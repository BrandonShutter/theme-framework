<?php
/**
 * Shortcodes
 *
 * @package     CHP Advertising Theme Framework
 * @subpackage  shortcode functions
 * @copyright   Copyright (c) 2013, CHP Advertising
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0 
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Formatter
 *
 * Prevents default wordpress filtering from occuring within any [raw] tags
 *
 * @access      private
 * @since       1.0 
 * @return      void
*/

function chp_formatter( $content ) {

	$new_content = '';
	$pattern_full = '{(\[raw\].*?\[/raw\])}is';
	$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
	$pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);

	foreach ( $pieces as $piece ) {
		if (preg_match($pattern_contents, $piece, $matches)) {
			$new_content .= $matches[1];
		} else {
			$new_content .= wptexturize(wpautop($piece));
		}
	}

	return $new_content;

}

remove_filter('the_content', 'wpautop');
remove_filter('the_content', 'wptexturize');
add_filter('the_content', 'chp_formatter', 99);
add_filter('widget_text', 'chp_formatter', 99);





/* ----------------------------------------------------------------------- *|
/* ------ General Shortcodes --------------------------------------------- *|
/* ----------------------------------------------------------------------- */


function chp_heading( $atts, $content = null ) {

	return '<h3>' . do_shortcode( $content ) . '</h3>';

} add_shortcode('heading', 'chp_heading');


function chp_h1( $atts, $content = null ) {

	return '<h1>' . do_shortcode( $content ) . '</h1>';

} add_shortcode('h1', 'chp_h1');


function chp_h2( $atts, $content = null ) {

	return '<h2>' . do_shortcode( $content ) . '</h2>';

} add_shortcode('h2', 'chp_h2');


function chp_h3( $atts, $content = null ) {

	return '<h3>' . do_shortcode( $content ) . '</h3>';

} add_shortcode('h3', 'chp_h3');


function chp_h4( $atts, $content = null ) {

	return '<h4>' . do_shortcode( $content ) . '</h4>';

} add_shortcode('h4', 'chp_h4');


function chp_h5( $atts, $content = null ) {

	return '<h5>' . do_shortcode( $content ) . '</h5>';

} add_shortcode('h5', 'chp_h5');


function chp_h6( $atts, $content = null ) {

	return '<h6>' . do_shortcode( $content ) . '</h6>';

} add_shortcode('h6', 'chp_h6');


function chp_separator( $atts, $content = null ) {

	return '<span class="separator"></span>';

} add_shortcode('separator', 'chp_separator');


/* ----------------------------------------------------------------------- *|
/* ------ Theme Specific Shortcodes -------------------------------------- *|
/* ----------------------------------------------------------------------- */




# END shortcodes.php


