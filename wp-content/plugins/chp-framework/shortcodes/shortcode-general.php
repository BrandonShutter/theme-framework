<?php
/**
 * General Shortcodes
 *
 * @package     CHP Framework
 * @copyright   Copyright (c) 2013, CHP Advertising
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       2.0 
*/

// Exit if accessed directly
if ( ! defined('ABSPATH') ) exit;


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


# END shortcode-general.php
