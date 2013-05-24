<?php
/**
 * Blog Functions
 *
 * @package     CHP Framework
 * @copyright   Copyright (c) 2013, CHP Advertising
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       2.0 
*/

// Exit if accessed directly
if ( ! defined('ABSPATH') ) exit;

/**
 * List Categories
 *
 * lists all of the categories attached to the post
 *
 * @since       2.0
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
 * Outputs the excerpt
 *
 * @since       2.0
 * @param       $post - the post to pull the excerpt from
 * @param       $length - the excerpt length
 * @param       $tags - which tags to exclude from being stripped
 * @param       $more - text to append to the excerpt
 * @return      string
*/

function chp_excerpt( $post = null, $length = null, $tags = '', $more = ' ...' ) {

	if ( is_null($post) )
		global $post;

	if ( has_excerpt( $post->ID ) )
		$excerpt = $post->post_excerpt;
	else
		$excerpt = $post->post_content;

	$excerpt = strip_shortcodes( strip_tags( $excerpt ), $tags );

	if ( ! is_null($length) && $length < strlen($excerpt) && is_numeric($length) ) {

		$excerpt = substr( $excerpt, 0, $length );
   		$excerpt = substr( $excerpt, 0, strrpos($excerpt, ' ') );  
		
	}

	if ( ! empty($excerpt) )
		$excerpt .= $more;

	return $excerpt;

}


/**
 * Pagination
 *
 * Outputs the pagination links
 *
 * @since       2.0
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
 * @since       2.0
 * @return      boolean
*/

function chp_has_pagination() {

	global $wp_query;

	return ( $wp_query->max_num_pages > 1 ) ? true : false;

}


/**
 * Post Thumbnail
 *
 * Will retrieve the post thumbnail for the current post by default, but if
 * an ID is passed, it will pull that post's thumbnail instead. 
 * Also has responsive support built right in ( WP adds in width and height
 * atts to img tags by default, and we don't want that when working 
 * with a responsive site )
 *
 * @since       2.0
 * @param       $post_id - the post ID
 * @param       $size    - the image size
 * @param       $echo    - whether or not to echo the data
 * @return      string
*/

function chp_post_thumbnail( $post_id = null, $size = 'thumbnail', $echo = true ) {

	global $post;

	if ( is_null($post_id) )
		$post_id = $post->ID;

	$attr = array( 'alt' => chp_image_caption( $post_id, false ) );

	if ( CHP_IS_RESPONSIVE ) {

		$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), $size );
		$thumbnail = sprintf( '<img src="%s" alt="%s" />', $thumbnail, $attr['alt'] );
	} else {

		$thumbnail = get_the_post_thumbnail( $post_id, $size, $attr );
	}

	if ( $echo == true )
		echo $thumbnail;
	else
		return $thumbnail;

}


/**
 * Image Caption
 *
 * Will retrieve the caption for the post thumbnail by default, but if
 * an ID is passed, it will pull that post's thumbnail caption instead
 *
 * @since       2.0
 * @param       $post_id - the post ID
 * @param       $echo - whether or not to echo the data
 * @return      string
*/

function chp_image_caption( $post_id = null, $echo = true ) {

	global $post;

	if ( is_null($post_id) )
		$post_id = $post->ID;

	$thumb_id = get_post_thumbnail_id( $post_id );

	$caption = ( chp_get_attachment_meta( $thumb_id, 'caption' ) ) ? chp_get_attachment_meta( $thumb_id, 'caption' ) : get_the_title( $post_id );

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
 * @since       2.0
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
 * @since       2.0
 * @param       $comment
 * @param       $args
 * @param       $depth
 * @return      string - the comment
*/

function chp_comments_template( $comment, $args, $depth ) {

	get_template_part('comment-loop');

}


/**
 * Main Query Args
 *
 * Handles the main query in a much more 
 *
 * @since       2.0
 * @param       $args - custom query args
 * @return      $args
*/

function chp_main_query_args( $args = array() ) {

	// Defaults
	$defaults = array(
		'post_type'      => 'post',
		'cat'            => ( chp_option('blog-category') )  ? absint( chp_option('blog-category') )  : 1,
		'posts_per_page' => ( chp_option('posts-per-page') ) ? absint( chp_option('posts-per-page') ) : get_option('posts_per_page'),
		'paged'          => ( get_query_var('paged') )       ? get_query_var('paged')                 : 1
	);

	if ( is_category() )
		$defaults['cat'] = get_query_var('cat');
	
	if ( is_author() )
		$defaults['author'] = get_query_var('author');

	if ( is_search() )
		$defaults['s'] = get_query_var('s');

	// Allow custom args to be passed through
	$args = wp_parse_args( $args, $defaults );

	return apply_filters( 'chp-main-query-args', $args );

}


/**
 * Posts Per Page
 *
 * Changes the default posts per page based on a number of conditionals:
 *
 * @since       2.0
 * @param       $query - the posts query
 * @return      $query
*/

function chp_posts_per_page( $query ) {

	if ( ! is_admin() ) {

		$default = get_option('posts_per_page', true);
		$chp_ppp = absint( chp_option('posts-per-page') );
		$ppp     = get_query_var('posts_per_page');

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


# END blog.php
