<?php
/**
 * Post Type
 *
 * @package     CHP Framework
 * @copyright   Copyright (c) 2013, CHP Advertising
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0 
*/

// Exit if accessed directly
if ( ! defined('ABSPATH') ) exit;

/**
 * Resets the permalinks on theme activation so that
 * the Custom Post Types are displayed properly
 * 
 * @since       1.0 
 * @return      void
*/

function chp_clear_permalinks() {

	flush_rewrite_rules();

} add_action('after_switch_theme', 'chp_clear_permalinks' );


/**
 * Registers all post types
 *
 * @since       1.0 
 * @return      void
*/

function chp_register_post_types() {

	$post_types = apply_filters('chp-post-types', chp_get_classes('CHP_Post_Type') );

	foreach ( $post_types as $post_type )
		new $post_type;

} add_action('init', 'chp_register_post_types');

/* ----------------------------------------------------------------------- *|
/* ------ CHP Post Type Class -------------------------------------------- *|
/* ----------------------------------------------------------------------- */

class CHP_Post_Type {

	var $ID;
	var $name;
	var $args     = array();
	var $metabox  = array();
	var $columns  = array();

	function __construct() {

		$this->register_post_type();
		$this->register_metabox();
		$this->register_columns();
		
		add_filter( "manage_edit-{$this->ID}_columns", array($this, 'create_columns') );
		add_action( 'manage_posts_custom_column', array($this, 'edit_columns'), 10, 2 );

	}

	/**
	 * Registers the CPT
	 *
	 * @access      private
	 * @since       1.0 
	 * @return      void
	*/

	function register_post_type() {

		// Cut off _CPT from class name
		$this->ID = substr( get_class($this), 0, -4 );

		// Turn CHP_* to chp-*
		$this->ID = str_replace( '_', '-', strtolower($this->ID) );

		// Turn chp-* to *
		$this->name = str_replace('chp-', '', $this->ID );

		/*
		 * Set up some defaults
		 */

		$single = ucfirst( $this->name );
		$plural = ucfirst( $single . 's' );

		$defaults = array(

			'labels' => array(
				'menu_name'          => $plural,
				'name'               => $plural,
				'single_name'        => $single,
				'add_new'            => 'Add New',
				'all_items'          => sprintf('All %s', $plural ),
				'add_new_item'       => sprintf('Add New %s', $single ),
				'edit_item'          => sprintf('Edit %s', $single ),
				'new_item'           => sprintf('Add New %s', $single ),
				'view_item'          => sprintf('View %s', $single ),
				'search_items'       => sprintf('Search %s', $plural ),
				'not_found'          => sprintf('No %s Found', $plural ),
				'not_found_in_trash' => sprintf('No %s Found in Trash', $plural )
			),
			'query_var' => $this->name,
			'rewrite'   => array(
				'slug' => $this->name . 's'
			),
			'public' => true,
			'supports' => array(
				'title',
				'editor',
				'thumbnail'
			)

		);

		// Compare Args
		$this->args = wp_parse_args( $this->args, $defaults );

		// Allow Args to be changed
		$this->args = apply_filters( "chp-post-type-{$this->ID}", $this->args );

		register_post_type( $this->ID, $this->args );

	}


	/**
	 * Registers the CPT meta box
	 *
	 * @access      private
	 * @since       1.0 
	 * @return      void
	*/

	function register_metabox() {

		if ( empty($this->metabox) )
			return;

		add_action('add_meta_boxes', array(&$this, 'add_metabox') );
		add_action('save_post', array(&$this, 'save_metabox') );

	}


	/**
	 * Adds the CPT Metabox
	 *
	 * @access      private
	 * @since       1.0 
	 * @return      void
	*/

	function add_metabox() {

		$mb = $this->metabox;

		$mb['id']       = $this->ID;
		$mb['page']     = $this->ID;
		$mb['callback'] = array($this, 'prepare_metabox');

		add_meta_box( $mb['id'], $mb['title'], $mb['callback'], $mb['page'], $mb['context'], $mb['priority'], $mb['fields'] );

	}


	/**
	 * Saves the CPT Meta Box
	 * 
	 * @access      private
	 * @since       1.0 
	 * @return      void
	*/

	function save_metabox( $id ) {

		global $post;

		if ( ! isset($post->post_type) || $post->post_type != $this->ID )
			return;

		foreach ( $this->metabox['fields'] as $field ) {

			if ( isset($_POST[ 'chp-' . $field ]) ) {

				update_post_meta(
					$post->ID,
					'chp-' . $field,
					trim( $_POST[ 'chp-' . $field ] )
				);

			}

		}

	}


	/**
	 * Prepares the CPT meta box by retrieving values for each field
	 *
	 * @since       1.0 
	 * @return      void
	*/

	function prepare_metabox( $post, $args ) {

		$data = array();

		foreach ( $args['args'] as $value )
			$data[ $value ] = get_post_meta( $post->ID, 'chp-' . $value, true );

		$this->metabox_output( $post, $data );

	}


	/**
	 * Outputs the meta box content
	 *
	 * @since       1.0
	 * @return      string - the content
	*/

	function metabox_output( $post, $data ) {

		// Will be overrided to output meta box content

	}

	/**
	 * Registers the custom columns
	 *
	 * @since       1.0 
	 * @return      array
	*/

	function register_columns() {

		// Will be overrided

	}


	/**
	 * Defines the custom columns and their order.
	 *
	 * @since       1.0 
	 * @return      array
	*/

	function create_columns( $columns ) {

		if ( empty($this->columns) )
			return $columns;

	    return $this->columns;

	}


	/**
	 * Renders the custom columns content.
	 *
	 * @since       1.0 
	 * @return      string - the post columns
	*/

	function edit_columns( $column_name, $post_id ) {

	    if ( get_post_type( $post_id ) == $this->ID )
        	$this->columns_output( $column_name, $post_id );

	}

	/**
	 * Outputs the post columns content
	 *
	 * @since       1.0 
	 * @return      string - the content
	*/

	function columns_output( $column_name, $post_id ) {

		// Will be overrided to output column content

	}

}


# END post-type.php
