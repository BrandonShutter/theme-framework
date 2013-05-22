<?php
/**
 * Settings
 *
 * @package     CHP Advertising Theme Framework
 * @subpackage  setting functions
 * @copyright   Copyright (c) 2013, CHP Advertising
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0 
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;


// * NOTE: Reliant upon the Option Tree Plugin

if ( function_exists('ot_get_option') ) {

	/**
	 * Get Option
	 *
	 * Returns the option provided if it was set, otherwise returns false 
	 *
	 * @access      public
	 * @since       1.0
	 * @param       $key - option name
	 * @return      bool / string
	*/

	function chp_get_option( $key ) {

		global $chpso;

		if ( !isset($chpso->$key) || empty($chpso->$key) )
			return false;

		return $chpso->$key;

	}

	/**
	 * Option
	 *
	 * Echos the option provided if it was set
	 *
	 * @access      public
	 * @since       1.0
	 * @param       $key - option name
	 * @return      string / void
	*/

	function chp_option( $key ) {

		if ( chp_get_option( $key ) )
			echo chp_get_option( $key );

	}

	/**
	 * Site Options
	 *
	 * Sets each option to an object attribute to be later used throughout the theme
	 *
	 * @access      private
	 * @since       1.0
	 * @return      string
	*/

	class chp_site_options {

		function __construct() {

			// Initially pull all of the options from Option Tree,
			// Then set each option to an object attribute
			$this->setup();

		}

		function setup() {

			// Option Tree options
			$ot_options = get_option('option_tree');

			if ( empty($ot_options) ) return false;
			
			foreach ( $ot_options as $key => $option ) {

				// checkbox option returns an array of the choices, but in our case we only need the first choice ( yes / no )
				$this->$key = ( is_array($option) && isset($option[0]) ) ? $option[0] : $option;

			}
		  
		}

		function debug() {

			echo '<pre>';

			print_r($this);

			echo '</pre>';

			die();

		}

	}

	/* CHP Site Options (chpso) */

	if ( !isset($chpso) ) {

		$chpso = new chp_site_options();

		// Uncomment this line to show what's contained in the object
		// $chpso->debug();

	}

}



# END settings.php
