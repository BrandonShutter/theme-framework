<?php
/**
 * Widget
 *
 * @package     CHP Framework
 * @copyright   Copyright (c) 2013, CHP Advertising
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       2.0 
*/

// Exit if accessed directly
if ( ! defined('ABSPATH') ) exit;

/**
 * Registers theme sidebars
 *
 * @since       2.0 
 * @return      void
*/

function chp_register_sidebars() {

	$sidebars = array();

	$sidebar['footer'] = register_sidebar( array(
		'name'          => 'Footer Widgets',
		'description'   => 'Widgets added to this section will be displayed in the footer.',
		'before_widget' => '<section class="widget">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget-heading"><h6>',
		'after_title'   => '</h6></div><div class="widget-content">'
	));

	/*
	 * Developer Hook - Can be used to add or remove sidebars to the theme
	*/
	$sidebars = apply_filters( 'chp-sidebars', $sidebar );

	foreach ( $sidebars as $sidebar )
		register_sidebar( $sidebar );

}

add_action('widgets_init', 'chp_register_sidebars', 5 );


/**
 * Registers all widgets
 *
 * @since       2.0 
 * @return      void
*/

function chp_register_widgets() {

	$widgets = apply_filters('chp-widgets', chp_get_classes('CHP_Widget') );

	foreach ( $widgets as $widget )
		register_widget( $widget );

}

add_action('widgets_init', 'chp_register_widgets', 5 );

/* ----------------------------------------------------------------------- *|
/* ------ CHP Widget Class ----------------------------------------------- *|
/* ----------------------------------------------------------------------- */

class CHP_Widget extends WP_Widget {

	var $ID;
	var $options  = array();
	var $defaults = array();

	function __construct() {

		// Turns Nuage_Widget to chp-widget
		$this->ID = str_replace( '_', '-', strtolower(get_class($this)) );

		$this->options  = wp_parse_args( $this->options, array(
			'name'         => '', // The name of the widget that appears on the widgets page in WP backend
			'description'  => '', // The description of the widget that appears on the widgets page in WP backend
			'class'        => ''  // CSS Class
		));

		$this->defaults = wp_parse_args( $this->defaults, array(
			'widget_title' => ''  // The default title for the widget
		));

		parent::__construct( $this->ID, $this->options['name'], $this->options );

	}


	function form( $instance ) {

		?>

		<?php // Widget Title ?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title</label>
			<input
				id="<?php echo $this->get_field_id('title'); ?>"
				name="<?php echo $this->get_field_name('title'); ?>"
				value="<?php echo ( isset($instance['title']) && !empty($instance['title']) ) ? esc_attr($instance['title']) : $this->defaults['widget_title']; ?>"
				class="widefat"
				type="text"
			/>
		</p>

		<?php

		$this->fields( $instance );

	}


	function fields( $instance ) {

		// Can be extended upon to display widget fields

	}


	function widget( $args, $instance ) {

		extract( $args );

		$before_widget = $this->add_class( $this->options['class'], $before_widget );

		$title = ( !empty($instance['title']) ) ? apply_filters('widget_title', $instance['title']) : $this->defaults['widget_title'];

		echo $before_widget;

			echo $before_title;
				echo $instance['title'];
			echo $after_title;

			$this->content( $instance );
		
		echo $after_widget;

	}


	function content( $args, $instance ) {

		// Can be extended upon to display widget content

	}


	/**
	 * Add Class
	 *
	 * Adds a class to the widget container provided
	 *
	 * @access      private
	 * @since       2.0
	 * @param       $class
	 * @param       $target
	 * @return      string
	*/

	function add_class( $class, $target ) {

		$regex = '#class="[^"]*#';

		preg_match( $regex, $target, $match ); // match becomes a variable of its own

		$target = preg_replace( $regex, $match[0] . ' ' . $class, $target );

		return $target;

	}

}


# END widget.php
