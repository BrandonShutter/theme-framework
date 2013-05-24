<?php
/*
Plugin Name: CHP Framework
Description: A simple framework that offers generic functionality for themes.
Version: 2.0
Author: Patrick Miravalle / CHP Advertising
Author URI: http://chpadvertising.com
*/

// Exit if accessed directly
if ( ! defined('ABSPATH') ) exit;

/* ----------------------------------------------------------------------- *|
/* ------ Plugin Constants ----------------------------------------------- *|
/* ----------------------------------------------------------------------- */

// Plugin Base Path
if ( ! defined('CHP_BASE') )
	define( 'CHP_BASE', plugin_dir_path( __FILE__ ) );

// Plugin Includes Path
if ( ! defined('CHP_INCLUDES') )
	define( 'CHP_INCLUDES', CHP_BASE . 'includes/' );

// Plugin Admin Includes Path
if ( ! defined('CHP_ADMIN') )
	define( 'CHP_ADMIN', CHP_BASE . 'includes/admin/' );

// Plugin Post Types Path
if ( ! defined('CHP_POST_TYPES') )
	define( 'CHP_POST_TYPES', CHP_BASE . 'post-types/' );

// Plugin Metaboxes Path
if ( ! defined('CHP_METABOXES') )
	define( 'CHP_METABOXES', CHP_BASE . 'metaboxes/' );

// Plugin Shortcodes Path
if ( ! defined('CHP_SHORTCODES') )
	define( 'CHP_SHORTCODES', CHP_BASE . 'shortcodes/' );

// Plugin Widgets Path
if ( ! defined('CHP_WIDGETS') )
	define( 'CHP_WIDGETS', CHP_BASE . 'widgets/' );

// Plugin CSS Path
if ( ! defined('CHP_CSS') )
	define( 'CHP_CSS', plugin_dir_url( __FILE__ ) . 'media/css/' );

// Plugin Images Path
if ( ! defined('CHP_IMAGES') )
	define( 'CHP_IMAGES', plugin_dir_url( __FILE__ ) . 'media/images/' );

// Plugin JS Path
if ( ! defined('CHP_JS') )
	define( 'CHP_JS', plugin_dir_url( __FILE__ ) . 'media/js/' );


/* ----------------------------------------------------------------------- *|
/* ------ Theme Constants ------------------------------------------------ *|
/* ----------------------------------------------------------------------- */

// Theme Base Path
if ( ! defined('THEME_BASE') )
	define( 'THEME_BASE', get_template_directory_uri() );

// Theme Post Types Path
if ( ! defined('THEME_POST_TYPES') )
	define( 'THEME_POST_TYPES', get_template_directory() . '/post-types/' );

// Theme Metaboxes Path
if ( ! defined('THEME_METABOXES') )
	define( 'THEME_METABOXES', get_template_directory() . '/metaboxes/' );

// Theme Shortcodes Path
if ( ! defined('THEME_SHORTCODES') )
	define( 'THEME_SHORTCODES', get_template_directory() . '/shortcodes/' );

// Theme Widgets Path
if ( ! defined('THEME_WIDGETS') )
	define( 'THEME_WIDGETS', get_template_directory() . '/widgets/' );

// CSS Directory
if ( ! defined('THEME_CSS') )
	define( 'THEME_CSS', THEME_BASE . '/media/css/' );

// Images Directory
if ( ! defined('THEME_IMAGES') )
	define( 'THEME_IMAGES', THEME_BASE . '/media/images/' );

// JS Directory
if ( ! defined('THEME_JS') )
	define( 'THEME_JS', THEME_BASE . '/media/js/' );


/* ----------------------------------------------------------------------- *|
/* ------ Initiate ------------------------------------------------------- *|
/* ----------------------------------------------------------------------- */

define('CHP_VERSION', '2.0');

/**
 * CHP Framework Class
 *
 * @package    CHP Framework
 * @author     CHP Advertising
 * @since      2.0
 */

class CHP_Framework {

	/* ---------------------
	 * Methods
	--------------------- */

	function __construct() {

		$this->constants();
		$this->includes();

		register_activation_hook(   __FILE__, array( $this, 'activate')   );
		register_deactivation_hook( __FILE__, array( $this, 'deactivate') );

		do_action( 'chp_loaded' );

	}


	/**
	 * Runs on plugin activation
	 *
	 * @access protected
	 * @return void
	 */

	function activate() {

		do_action('chp_activate');

	}


	/**
	 * Runs on plugin de-activation
	 *
	 * @access protected
	 * @return void
	 */

	function deactivate() {

		do_action('chp_deactivate');

	}

	/**
	 * Constants
	 *
	 * sets up toggleable constants
	 *
	 * @access private
	 * @return void
	 */

	function constants() {

		if ( ! defined('CHP_IS_BLOG') )
			define('CHP_IS_BLOG', false );

		if ( ! defined('CHP_IS_RESPONSIVE') )
			define('CHP_IS_RESPONSIVE', false );

	}

	/**
	 * Includes
	 *
	 * includes all required files on init
	 *
	 * @access private
	 * @return void
	 */

	function includes() {

		// Includes //
		include_once( CHP_INCLUDES . 'cleanup.php'   );
		include_once( CHP_INCLUDES . 'settings.php'  );
		include_once( CHP_INCLUDES . 'functions.php' );
		include_once( CHP_INCLUDES . 'styles.php'    );
		include_once( CHP_INCLUDES . 'scripts.php'   );
		include_once( CHP_INCLUDES . 'post-type.php' );
		include_once( CHP_INCLUDES . 'widget.php'    );
		include_once( CHP_INCLUDES . 'metabox.php'   );
		include_once( CHP_INCLUDES . 'pages.php'     );
		include_once( CHP_INCLUDES . 'user.php'      );
		include_once( CHP_INCLUDES . 'menus.php'     );
		include_once( CHP_INCLUDES . 'blog.php'      );
		include_once( CHP_INCLUDES . 'template.php'  );

		// Admin Includes //
		include_once( CHP_ADMIN . 'functions.php' );
		include_once( CHP_ADMIN . 'login.php'     );
		include_once( CHP_ADMIN . 'cleanup.php'   );
		include_once( CHP_ADMIN . 'restrict.php'  );

		// Include Post Types
		chp_include_files( array(CHP_POST_TYPES, THEME_POST_TYPES) );

		// Include Metaboxes
		chp_include_files( array(CHP_METABOXES, THEME_METABOXES) );

		// Include Shortcodes //
		chp_include_files( array(CHP_SHORTCODES, THEME_SHORTCODES) );

		// Include Widgets //
		chp_include_files( array(CHP_WIDGETS, THEME_WIDGETS) );

	}

}

// Initiate CHP Framework //
$GLOBALS['CHP'] = new CHP_Framework();



