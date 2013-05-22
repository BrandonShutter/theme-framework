<?php
/**
 * Functions
 *
 * @package     CHP Advertising Theme Framework
 * @subpackage  theme functions
 * @copyright   Copyright (c) 2013, CHP Advertising
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0 
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;


// Add Featured Images Support
add_theme_support('post-thumbnails');


/* ----------------------------------------------------------------------- *|
/* ------ General Functions ---------------------------------------------- *|
/* ----------------------------------------------------------------------- */

/**
 * Dynamic Sidebar
 *
 * If a sidebar is set to the current page from the theme metabox, then display it.
 * Otherwise, default to the primary theme sidebar ('Sidebar')
 *
 * @access      public
 * @since       1.0 
 * @return      void
*/

function chp_dynamic_sidebar() {

	global $post;

	$sidebar = ( isset($post) && get_post_meta( $post->ID, 'chp-page-sidebar', true ) != 'none-selected' ) ? get_post_meta( $post->ID, 'chp-page-sidebar', true ) : 'Sidebar';

	// Just an extra precaution
	if ( empty($sidebar) )
		$sidebar = 'Sidebar';

	dynamic_sidebar( apply_filters('chp-dynamic-sidebar', $sidebar) );

	/*
	 * Action Hook - Can be used to add more items to the sidebar
	 */

	do_action('chp-after-sidebar');

}


/**
 * Copyright
 *
 * Outputs the site copyright
 *
 * @access      public
 * @since       1.0 
 * @param       $separator - copyright separator
 * @return      string
*/

function chp_copyright( $separator = '·' ) {

	$copyright = chp_get_option('copyright');

	if ( $copyright )
		return $copyright;

	$year = date('Y');
	$name = get_bloginfo('name');

	$output = sprintf('Copyright © %s %s %s', $year, $separator, $name );

	return $output;

}


/**
 * Custom CSS
 *
 * Outputs the theme's custom css if set in the theme options panel
 *
 * @access      public
 * @since       1.0
 * @return      string
*/

function chp_custom_css() {

	$custom_css = chp_get_option('custom_css');
	
	if ( $custom_css ):

		$output  = '<!-- Custom CSS -->';
		$output .= '<style>';
		$output .= $custom_css;
		$output .= '</style>';

		echo $output;

	endif;

}


/**
 * Analytics
 *
 * Outputs the theme's google analytics if set in the theme options panel
 *
 * @access      public
 * @since       1.0
 * @return      string
*/

function chp_analytics() {

	$analytics = chp_get_option('google_analytics');
	
	if ( $analytics ):

		$output  = '<!-- Google Analytics Tracking Code -->';
		$output .= '<script type="text/javascript">';
		$output .= $analytics;
		$output .= '</script>';

		echo $output;

	endif;

}


/* ----------------------------------------------------------------------- *|
/* ------ Blog Functions ------------------------------------------------- *|
/* ----------------------------------------------------------------------- */


/**
 * List Categories
 *
 * lists all of the categories attached to the post
 *
 * @access      public
 * @since       1.0
 * @param       $excluded - ID of the category to exclude
 * @param       $link - whether or not to make the categories link
 * @param       $separator
 * @param       $before
 * @param       $after
 * @return      string - the categories
*/

function chp_list_cats( $excluded = false, $link = true, $separator = ', ', $before = '', $after = '' ) {

	$cats = array();

	foreach ( array_reverse(get_the_category()) as $category ) {

		if ( $excluded != false && $category->cat_ID == $excluded )
			continue;

		$cat = $category->cat_name;

		if ( $link == true )
			$cat = sprintf('<a href="%s">%s</a>', get_category_link($category->term_id), $cat );

		$cats[] = $before . $cat . $after;

	}

	echo implode( $separator, $cats );
}


/**
 * List Terms
 *
 * lists all of the terms attached to the post
 *
 * @access      public
 * @since       1.1
 * @param       $tax - Name of taxonomy to retrieve terms from
 * @param       $excluded - ID of the taxonomy to exclude
 * @param       $link - whether or not to make the terms link
 * @param       $separator
 * @param       $before
 * @param       $after
 * @return      string - the terms
*/

function chp_list_terms( $tax = '', $excluded = false, $link = true, $separator = ', ', $before = '', $after = '' ) {

	$output = array();

	$terms = get_the_terms( get_the_ID(), $tax );

	if ( is_wp_error( $terms ) || empty( $terms ) )
		return;

	foreach ( $terms as $item ) {

		if ( $excluded != false && $item->term_id == $excluded )
			continue;

		$term = $item->name;

		if ( $link == true )
			$term = sprintf('<a href="%s">%s</a>', get_term_link($item), $term );

		$output[] = $before . $term . $after;

	}

	echo implode( $separator, $output );
}


/**
 * Breadcrumbs
 *
 * Displays breadcrumbs
 *
 * @access      public
 * @since       1.0
 * @return      string - the breadcrumbs
*/

function chp_breadcrumbs() {

	global $post;

	$output  = '<ul>';

		if ( is_front_page() ):
			
			$output .= '<li class="home">You are home.<li>';

		elseif ( is_404() ):

			$output .= '<li><a href="'. get_bloginfo('url') .'">Home</a></li>';
			$output .= '<li>404 error</li>';
		
		else:

			$output .= '<li><a href="'. get_bloginfo('url') .'">Home</a></li>';

			// blog page
			if ( is_home() )
				$output .= '<li><a href="'. site_url('blog') .'">Blog</a></li>';

			if ( is_category() || is_single() ) {
				$category = get_the_category();

				if ( in_category( chp_get_option('blog_category') ) )
					$output .= '<li><a href="' . site_url('blog') . '">Blog</a></li>';
				
			}

			if ( is_single() || is_page() )
			 	$output .= '<li><a href="'. get_permalink() .'">'. get_the_title() .'</a>'; 

		endif;

	$output .= '</ul>';

	echo $output;

}


/**
 * Pagination
 *
 * Outputs the pagination links
 *
 * @access      public
 * @since       1.0
 * @param       $echo - whether or not to echo the output
 * @param       $classes - additional classes to add to the container
 * @return      string - the pagination links
*/

function chp_pagination( $echo = true, $classes = '' ) {

	if ( chp_has_pagination() ) {

		$current_page = max(1, get_query_var('paged') );

		$output = sprintf('<nav class="pagination %s cf">', $classes);
	
			$output .= '<ol>';

				for ( $i = 1; $i <= $total_pages; $i++ ) {

					if ( $i == $current_page ) {

						$output .= sprintf('<li class="current">%s</li>', $i );

					} else {

						$output .= sprintf('<li><a href="%s">%s</a></li>', get_pagenum_link($i), $i );

					}

				}

			$output .= '</ol>';

		$output .= '</nav>';

		if ( $echo == true )
			echo $output;
		else
			return $output;

	}

}


/**
 * Has Pagination
 *
 * Determines whether or not pagination is needed ( if there is more than one page )
 *
 * @access      public
 * @since       1.0
 * @return      boolean
*/

function chp_has_pagination() {

	global $wp_query;

	return ( $wp_query->max_num_pages > 1 ) ? true : false;

}


/**
 * Posts Per Page
 *
 * Changes the default posts per page based on a number of conditionals:
 *
 * @access      public
 * @since       1.0
 * @param       $query - the posts query
 * @return      $query
*/

function chp_posts_per_page( $query ) {

	if ( !is_admin() ) {

		$default = get_option('posts_per_page', true);
		$chp_ppp = (int) chp_get_option('posts_per_page');
		$ppp = get_query_var('posts_per_page');

		/*
		 * Change the default to the value set in the theme options panel
		 */

		if ( $chp_ppp >= 1 )
			$default = $chp_ppp;

		/*
		 * If the 'posts per page' query var is set,
		 * override the default with the value set in the query var
		 */

		if ( $ppp )
			$default = $ppp;

	    set_query_var('posts_per_page', apply_filters( 'chp-posts-per-page', $default ) );

	}

	return $query;

}

add_action( 'pre_get_posts', 'chp_posts_per_page' );


/**
 * Post Thumbnail
 *
 * Simply displays the post thumbnail.
 *
 * @access      public
 * @since       1.0
 * @param       $id - the post ID
 * @return      string
*/

function chp_post_thumbnail( $id = null, $width = '', $height = '' ) {

	global $post;

	if ( is_null($id) || is_numeric($id) )
		$id = get_post_thumbnail_id( $post->ID );

	printf( '<a href="%s">', get_permalink( $post->ID) );
	printf( '<img src="%s" alt="%s" width="%s" height="%s"></a>',

		chp_image_url( $post->ID, false ),
		chp_image_caption( $post->ID, false ),
		( ! empty( $width )  && is_numeric($width)  ) ? $width  : '',
		( ! empty( $height ) && is_numeric($height) ) ? $height : ''

	);

}


/**
 * Image Url
 *
 * retrieves the url for the image.
 *
 * Will retrieve the url for the post thumbnail by default, but if
 * an ID is passed, it will pull that image's url instead.
 *
 * @access      public
 * @since       1.0
 * @param       $id   - the image attachment ID
 * @param       $echo - whether or not to echo the data
 * @return      string
*/

function chp_image_url( $id = null, $echo = true ) {

	global $post;

	if ( is_null($id) || is_numeric($id) )
		$id = get_post_thumbnail_id( $post->ID );

	$url = wp_get_attachment_url( $id );

	if ( $echo == true )
			echo $url;
		else
			return $url;

}


/**
 * Image Caption
 *
 * retrieves the caption for the image.
 *
 * Will retrieve the caption for the post thumbnail by default, but if
 * an ID is passed, it will pull that image's caption instead.
 *
 * @access      public
 * @since       1.0
 * @param       $id   - the image attachment ID
 * @param       $echo - whether or not to echo the data
 * @return      string
*/

function chp_image_caption( $id = null, $echo = true ) {

	global $post;

	if ( is_null($id) || is_numeric($id) )
		$id = get_post_thumbnail_id( $post->ID );

	$caption = ( chp_get_attachment_meta( $id, 'caption' ) ) ? chp_get_attachment_meta( $id, 'caption' ) : get_the_title( $post->ID );

	if ( $echo == true )
			echo $caption;
		else
			return $caption;

}


/**
 * Get Attachment Meta
 *
 * Retrieves meta data for the attachment provided.
 *
 * @access      public
 * @since       1.0
 * @param       $id  - the attachment ID
 * @param       $key - the attachment meta to retrieve
 * @return      array || string || boolean
*/

function chp_get_attachment_meta( $id, $key = null ) {

	$attachment = get_post( $id );

	$meta = array(
		'alt'         => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
		'caption'     => $attachment->post_excerpt,
		'description' => $attachment->post_content,
		'href'        => get_permalink( $attachment->ID ),
		'src'         => $attachment->guid,
		'title'       => $attachment->post_title
	);

	if ( ! is_null($key) && array_key_exists($key, $meta) ) 
		return $meta[ $key ];

	return $meta;

}


/**
 * Comments Template
 *
 * Outputs comments based off the template below
 *
 * @access      public
 * @since       1.0
 * @param       $comment
 * @param       $args
 * @param       $depth
 * @return      string - the comment
*/

function chp_comments_template( $comment, $args, $depth ) {

	$GLOBALS['comment'] = $comment;

	?>

	<li id="comment-<?php comment_ID(); ?>" class="comment">
		<div class="heading">
			<strong class="name"><?php comment_author_link(); ?></strong>
			<span class="date"><?php printf( '%s at %s', get_comment_date(), get_comment_time() ); ?></span>
		</div>
		<div class="info">
			<p><?php comment_text(); ?></p>
		</div>
		<?php comment_reply_link( array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']) ) ); ?>
	</li>

	<?php

}


/* ----------------------------------------------------------------------- *|
/* ------ Helper Functions ----------------------------------------------- *|
/* ----------------------------------------------------------------------- */

/**
 * Post Exists
 *
 * Checks to see if a post exists by title
 *
 * @access      public
 * @since       1.0
 * @param       title
 * @return      boolean
*/

function chp_post_exists( $title ) {

	global $wpdb;
	return $wpdb->get_row("SELECT * FROM wp_posts WHERE post_title = '" . $title . "'", 'ARRAY_A');

}




# END functions.php
