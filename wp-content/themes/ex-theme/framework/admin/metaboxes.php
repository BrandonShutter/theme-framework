<?php
/**
 * Metaboxes
 *
 * @package     CHP Advertising Theme Framework
 * @subpackage  metabox functions
 * @copyright   Copyright (c) 2013, CHP Advertising
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0 
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Register Metaboxes
 *
 * Registers theme metaboxes
 *
 * @access      private
 * @since       1.0 
 * @return      void
*/

function chp_register_metaboxes() {

	new chp_page_tagline();
	new chp_page_sidebar();

	/*
     * Action Hook - Can be used to add additional metaboxes to the theme
     */

    do_action('chp-register-metaboxes');

}

add_action('load-post.php', 'chp_register_metaboxes');
add_action('load-post-new.php', 'chp_register_metaboxes');


/**
 * Page Tagline
 *
 * Outputs the page tagline metabox
 *
 * @access      public
 * @since       1.0 
 * @return      void
*/

class chp_page_tagline extends chp_metabox {

	function __construct() {

		$this->args = array(
			'id' => 'chp-page-tagline',
			'title' => 'Page Tagline',
			'callback' => array(&$this, 'output'),
			'post_type' => 'page',
			'context' => 'side',
			'priority' => 'default'
		);

		$this->fields = array(
			'chp-page-tagline'
		);

		parent::__construct();

	}

	function output( $post ) {

		$this->nonce();

		$value = get_post_meta($post->ID, 'chp-page-tagline', true);

		printf('<textarea class="widefat" name="%s" rows="5">%s</textarea>', 'chp-page-tagline', $value );

	}

}


/**
 * Page Sidebar
 *
 * Outputs the page sidebar metabox
 *
 * @access      public
 * @since       1.0 
 * @return      void
*/

class chp_page_sidebar extends chp_metabox {

	function __construct() {

		$this->args = array(
			'id' => 'chp-page-sidebar',
			'title' => 'Page Sidebar',
			'callback' => array(&$this, 'output'),
			'post_type' => 'page',
			'context' => 'side',
			'priority' => 'default'
		);

		$this->fields = array(
			'chp-page-sidebar'
		);

		parent::__construct();

	}

	function output( $post ) {

		$this->nonce();

		$value = get_post_meta( $post->ID, 'chp-page-sidebar', true );

		$output  = sprintf('<select class="widefat" type="text" name="%s" value="%s">', 'chp-page-sidebar', $value);

		$output .= '<option value="none-selected">-- Select a Sidebar --</option>';

		foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ):

			$output .= sprintf('<option value="%s" %s>%s</option>', ucwords( $sidebar['name']), selected( $sidebar['name'], $value, false), ucwords( $sidebar['name']) );

		endforeach;

		$output .= '</select>';

		echo $output;

	}

}




/**
 * Metabox
 *
 * New metaboxes can be easily created by extending this class
 *
 * @access      public
 * @since       1.0 
 * @return      void
*/

class chp_metabox {

	var $args   = array();
	var $fields = array();
	
	function __construct() {

		add_action('add_meta_boxes', array(&$this, 'add') );
		add_action('save_post', array(&$this, 'save'), 10, 2);

	}

	function add() {

		add_meta_box( $this->args['id'], $this->args['title'], $this->args['callback'], $this->args['post_type'], $this->args['context'], $this->args['priority'] );

	}

	function save( $post_id, $post ) {

		$post_type = get_post_type_object( $post->post_type );

		if ( !isset($_POST[ $this->args['id'] . '-nonce' ]) || !wp_verify_nonce($_POST[ $this->args['id'] . '-nonce' ], basename(__FILE__)) || !current_user_can($post_type->cap->edit_post, $post->ID) )
			return $post_id;


		foreach ( $this->fields as $field ) {

			$new = ( isset($_POST[ $field ]) ) ? $_POST[ $field ] : '';
			$old = get_post_meta( $post->ID, $field, true );

			// Add
			if ( $new && !$old )
				add_post_meta( $post->ID, $field, $new, true );

			// Update
			elseif ( $new && $new != $old )
				update_post_meta( $post->ID, $field, $new );

			// Delete
			elseif ( $old && $new == '' )
				delete_post_meta( $post->ID, $field, $old );

		}

	}

	function output() {

		// This will be extended upon to output the metabox content

	}

	function nonce() {

		wp_nonce_field( basename(__FILE__), $this->args['id'] . '-nonce' );

	}

}


# END metaboxes.php