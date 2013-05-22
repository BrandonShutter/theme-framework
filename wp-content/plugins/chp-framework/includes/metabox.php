<?php
/**
 * Metabox
 *
 * @package     CHP Framework
 * @copyright   Copyright (c) 2013, CHP Advertising
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0 
*/

// Exit if accessed directly
if ( ! defined('ABSPATH') ) exit;

/**
 * Registers all metaboxes
 *
 * @since       1.0 
 * @return      void
*/

function chp_register_metaboxes() {

    $metaboxes = apply_filters('chp-metaboxes', chp_get_classes('CHP_Metabox') );

    foreach ( $metaboxes as $metabox )
        new $metabox;

}

add_action('admin_menu', 'chp_register_metaboxes', 5 );

/* ----------------------------------------------------------------------- *|
/* ------ CHP Metabox Class ---------------------------------------------- *|
/* ----------------------------------------------------------------------- */

class CHP_Metabox {

    var $ID;
    var $args   = array();
    var $fields = array();
    
    function __construct() {

        // Turns Nuage_*_Metabox to chp-*-metabox
        $this->ID = str_replace( '_', '-', strtolower(get_class($this)) );

        add_action( 'add_meta_boxes', array($this, 'add')         );
        add_action( 'save_post',      array($this, 'save'), 10, 2 );

    }


    function add() {
        
        add_meta_box( $this->ID, $this->args['title'], array($this, 'callback'), $this->args['post_type'], $this->args['context'], $this->args['priority'] );

    }


    function save( $post_id, $post ) {

        $post_type = get_post_type_object( $post->post_type );

        if ( ! current_user_can($post_type->cap->edit_post, $post_id) )
            return false;

        if ( ! isset($_POST[ $this->ID . '-nonce' ]) || ! wp_verify_nonce($_POST[ $this->ID . '-nonce' ], basename(__FILE__)) )
            return false;

        foreach ( $this->fields as $field ) {

            $field = 'chp-' . $field;

            $new = ( isset($_POST[ $field ]) ) ? $_POST[ $field ] : '';
            $old = get_post_meta( $post_id, $field, true );

            // Add
            if ( $new && ! $old )
                add_post_meta( $post_id, $field, $new, true );

            // Update
            elseif ( $new && $new != $old )
                update_post_meta( $post_id, $field, $new );

            // Delete
            elseif ( $old && $new == '' )
                delete_post_meta( $post_id, $field, $old );

        }

    }

    function callback( $post ) {

        wp_nonce_field( basename(__FILE__), $this->ID . '-nonce' );

        $this->output( $post );
        
    }


    function output( $post ) {

        // This will be extended upon to output the metabox content

    }

}


# END metabox.php
