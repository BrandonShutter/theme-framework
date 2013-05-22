<?php
/**
 * Post Types
 *
 * @package     CHP Advertising Theme Framework
 * @subpackage  post type functions
 * @copyright   Copyright (c) 2013, CHP Advertising
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0 
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Registers each custom post type
 *
 * @access      private
 * @since       1.0 
 * @return      void
*/

function chp_custom_post_types() {

	new chp_slide();

} add_action('init', 'chp_custom_post_types');



/*
 * Slide Post Type
*/

class chp_slide extends chp_custom_post_type {

	function __construct() {

		parent::__construct();

	}

	function register_post_type() {

		$this->name = 'slide';

		$this->args['supports'] = array('title', 'thumbnail');

		parent::register_post_type();

	}


	function register_meta_box() {

		$this->meta_box = array(
			'title'     => 'Slide Details',
			'context'   => 'normal',
			'priority'  => 'high',
			'fields'    => array(
				'slide-link',
			)
		);

		parent::register_meta_box();

	}


	function meta_box_output( $post, $data ) {

		?>

		<p>
			<label for="chp-slide-link">Slide Link:</label>
			<input id="chp-slide-link" class="widefat" type="text" name="chp-slide-link" value="<?php echo esc_attr( $data['slide-link'] ); ?>">
			<small>( Optional ) Enter in a url for the slide to link to.</small>
		</p>

		<?php


	}



} // End Slide CPT






/**
 * Custom Post Type
 *
 * Handle the theme custom post types
 *
 * @access      public
 * @since       1.0 
*/

class chp_custom_post_type {

	var $name;
	var $args = array();
	var $meta_box = array();

	function __construct() {

		$this->register_post_type();
		$this->register_meta_box();

		// Clear the permalinks
		add_action('after_switch_theme', array(&$this, 'reset_permalinks') );

	}


	/**
	 * Resets the permalinks on theme activation so that the CPT is retrieved properly
	 *
	 * @access      private
	 * @since       1.0 
	 * @return      void
	*/

	function reset_permalinks() {

		flush_rewrite_rules();

	}


	/**
	 * Registers the CPT
	 *
	 * @access      private
	 * @since       1.0 
	 * @return      void
	*/

	function register_post_type() {

		/*
	 	 * If the name isn't set, then default to the classname
	 	*/

		if ( empty($this->name) )
			$this->name = substr( get_class( $this ), 4 );

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


		// Create the post type
		register_post_type('chp-' . $this->name, apply_filters('chp-cpt-' . $this->name, $this->args) );

		// Adds category selection for the post type
		register_taxonomy_for_object_type('category', 'chp-' . $this->name );

	}


	/**
	 * Registers the CPT meta box
	 *
	 * @access      private
	 * @since       1.0 
	 * @return      void
	*/

	function register_meta_box() {

		if ( empty($this->meta_box) )
			return;

		add_action('add_meta_boxes', array(&$this, 'add_meta_box') );
		add_action('save_post', array(&$this, 'save_meta_box') );

	}


	/**
	 * Adds the CPT Meta Box
	 *
	 * @access      private
	 * @since       1.0 
	 * @return      void
	*/

	function add_meta_box() {

		$mb = $this->meta_box;

		$mb['id']       = 'chp-' . $this->name;
		$mb['page']     = 'chp-' . $this->name;
		$mb['callback'] = array(&$this, 'prepare_meta_box');

		add_meta_box( $mb['id'], $mb['title'], $mb['callback'], $mb['page'], $mb['context'], $mb['priority'], $mb['fields'] );

	}


	/**
	 * Saves the CPT Meta Box
	 * 
	 * @access      private
	 * @since       1.0 
	 * @return      void
	*/

	function save_meta_box( $id ) {

		global $post;

		// No sense in running code if it's not even a CPT
		if ( ! isset($post->post_type) || $post->post_type == 'page' || $post->post_type == 'post' )
			return;


		foreach ( $this->meta_box['fields'] as $field ) {

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
	 * @access      private
	 * @since       1.0 
	 * @return      void
	*/

	function prepare_meta_box( $post, $args ) {

		$data = array();

		foreach ( $args['args'] as $value )
			$data[ $value ] = get_post_meta( $post->ID, 'chp-' . $value, true );

		$this->meta_box_output( $post, $data );

	}


	/**
	 * Outputs the meta box content
	 *
	 * @access      protected
	 * @since       1.0 
	 * @return      string - the content
	*/

	function meta_box_output( $post, $data ) {

		// Will be overrided to output meta box content

	}

}




# END post-types.php
