<?php
/**
 * CHP Theme Framework
 *
 * @package     CHP Advertising Theme Framework
 * @author      Patrick Miravalle
 * @link        http://chpadvertising.com
 * @copyright   Copyright (c) 2013, CHP Advertising
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @version     1.0 
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;


define('THEME_VERSION', '1.0');


/* ----------------------------------------------------------------------- *|
/* ------ Directories ---------------------------------------------------- *|
/* ----------------------------------------------------------------------- */

if ( ! defined('THEME_BASE') )
	define( 'THEME_BASE', get_template_directory_uri() );

// CSS Directory
if ( ! defined('THEME_CSS') )
	define( 'THEME_CSS', THEME_BASE . '/style/css/' );

// JS Directory
if ( ! defined('THEME_JS') )
	define( 'THEME_JS', THEME_BASE . '/js/' );

// Includes Directory
if ( ! defined('THEME_INCLUDES') )
	define( 'THEME_INCLUDES', TEMPLATEPATH . '/framework/includes/' );

// Assets Directory
if ( ! defined('THEME_ASSETS') )
	define( 'THEME_ASSETS', TEMPLATEPATH . '/framework/assets/' );

// Admin Directory
if ( ! defined('THEME_ADMIN') )
	define( 'THEME_ADMIN', TEMPLATEPATH . '/framework/admin/' );


/* ----------------------------------------------------------------------- *|
/* ------ Includes ------------------------------------------------------- *|
/* ----------------------------------------------------------------------- */


// Load Include Files
require_once( THEME_INCLUDES . 'functions.php' );
require_once( THEME_INCLUDES . 'settings.php'  );
require_once( THEME_INCLUDES . 'post-types.php');
require_once( THEME_INCLUDES . 'pages.php'     );
require_once( THEME_INCLUDES . 'menus.php'     );
require_once( THEME_INCLUDES . 'sidebars.php'  );
require_once( THEME_INCLUDES . 'user.php'      );
require_once( THEME_INCLUDES . 'overrides.php' );
require_once( THEME_INCLUDES . 'login.php'     );

// Load Assets Files
require_once( THEME_ASSETS . 'css.php'         );
require_once( THEME_ASSETS . 'javascript.php'  );
require_once( THEME_ASSETS . 'shortcodes.php'  );
require_once( THEME_ASSETS . 'widgets.php'     );

if ( is_admin() ):

// Load Admin Files
require_once( THEME_ADMIN . 'functions.php'    );
require_once( THEME_ADMIN . 'metaboxes.php'    );

endif;


# END init.php
