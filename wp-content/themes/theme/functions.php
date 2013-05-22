<?php
/**
 * Theme Functions
 *
 * @author 		CHP Advertising
 * @package 	CHP Theme Framework
 * @since       1.0
 */

function chp_framework_check() {

	if ( ! defined('CHP_VERSION') )
		printf( '<h2>%s</h2>', __('The CHP Framework Plugin must be activated in order for this theme to function properly!', 'chp') );

} add_action('after_switch_theme', 'chp_framework_check');

/* ----------------------------------------------------------------------- *|
/* ------ Theme Specific Functions Go Below This Line -------------------- *|
/* ----------------------------------------------------------------------- */


