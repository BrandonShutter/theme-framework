<?php
/**
 * General Functions
 *
 * @package     CHP Framework
 * @copyright   Copyright (c) 2013, CHP Advertising
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       2.0 
*/

// Exit if accessed directly
if ( ! defined('ABSPATH') ) exit;

/**
 * Includes all files from the directory or directories provided ( so long as they exist ).
 *
 * @since       2.0
 * @param       array $directories
 * @return      void
*/

function chp_include_files( $directories ) {

	foreach ( $directories as $directory ) {

		if ( ! file_exists($directory) )
			continue;

		foreach ( glob( trailingslashit($directory) . '*.php') as $file )
			include_once( $file );
	}

}


/**
 * Returns all class names that are children of the parent provided
 *
 * @since       2.0
 * @param       $parent - the parent class to be used for the query
 * @return      void
*/

function chp_get_classes( $parent ) {

	$children = array();
	$classes  = get_declared_classes();

	// Reverse for performance
	foreach ( array_reverse($classes) as $class ) {

		if ( is_subclass_of($class, $parent) )
			$children[] = $class;

	}

	return $children;

}



# END functions.php
