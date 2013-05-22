<?php
/**
 * Menus
 *
 * @package     CHP Advertising Theme Framework
 * @subpackage  menu functions
 * @copyright   Copyright (c) 2013, CHP Advertising
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0 
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;


/**
 * Register Menus
 *
 * Registers theme menus
 *
 * @access      private
 * @since       1.0 
 * @return      void
*/

function chp_register_menus() {

    register_nav_menu('Main Menu', 'Main Menu');
    register_nav_menu('Footer Menu', 'Footer Menu');

    /*
     * Action Hook - Can be used to add additional menus to the theme
     */
    
    do_action('chp-register-menus');

} add_action('init', 'chp_register_menus');


/**
 * Custom Menu
 *
 * Customizes the default WP menu args
 *
 * @access      private
 * @since       1.0
 * @param       $args - the menu args
 * @return      array
*/

function chp_custom_menu( $args = '' ) {

    $args['container']  = false;
    $args['menu_id']    = '';
    $args['items_wrap'] = '%3$s';
    $args['depth']      = 2;
    $args['walker']     = new chp_custom_menu_walker();

    return $args;

} add_filter( 'wp_nav_menu_args', 'chp_custom_menu' );


/**
 * Custom Menu Walker
 *
 * Adds a class of 'parent' to all dropdown menu parents
 *
 * @access      private
 * @since       1.0
 * @return      string
*/

class chp_custom_menu_walker extends Walker_Nav_Menu {

    function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {

        /*
         * Filter Hook - adds the ability to conditionally show nav items
         */

        $show = apply_filters('chp-show-nav-item', true, $element );

        if ( $show == false )
            return;
        
        $id_field = $this->db_fields['id'];

        if ( is_object( $args[0] ) )
            $args[0]->has_children = ! empty( $children_elements[$element->$id_field] );

        return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }

    function start_el( &$output, $item, $depth, $args ) {

        if ( $args->has_children )
            array_push( $item->classes, $class = 'parent' );

        $output .= sprintf( apply_filters('chp-menu-item', '<li class="%s"><a href="%s">%s</a>', $args), implode($item->classes, ' '), $item->url, $item->title );

    }

    function end_el( &$output, $item, $depth, $args ) {

        $output .= apply_filters('chp-end-menu-item', '</li>');

    }

}



# END menus.php
