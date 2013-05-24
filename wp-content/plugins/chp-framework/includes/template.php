<?php
/**
 * Template
 *
 * @package     CHP Framework
 * @copyright   Copyright (c) 2013, CHP Advertising
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       2.0 
*/

// Exit if accessed directly
if ( ! defined('ABSPATH') ) exit;

/**
 * Prevents default wordpress filtering from occuring within any [raw] tags
 *
 * @since       2.0 
 * @return      void
*/

function chp_formatter( $content ) {

	$new_content      = '';
	$pattern_full     = '{(\[raw\].*?\[/raw\])}is';
	$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
	$pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);

	foreach ( $pieces as $piece ) {
		if (preg_match($pattern_contents, $piece, $matches)) {
			$new_content .= $matches[1];
		} else {
			$new_content .= wptexturize(wpautop($piece));
		}
	}

	return $new_content;

}

remove_filter('the_content', 'wpautop');
remove_filter('the_content', 'wptexturize');
add_filter('the_content', 'chp_formatter', 99);
add_filter('widget_text', 'chp_formatter', 99);


/**
 * Adds featured image support for the theme
 *
 * @since       2.0 
 * @return      void
*/

function chp_thumbnail_support() {

	add_theme_support('post-thumbnails');

} add_action('init', 'chp_thumbnail_support');


/**
 * Simply echos or returns the page name
 *
 * @since       2.0 
 * @param       $echo - whether or not the echo the pagename
 * @return      string
*/

function chp_pagename( $echo = true ) {

	global $pagename;

	if ( is_front_page() )
		$pagename = 'homepage';

	if ( $echo == true )
		echo $pagename;
	else
		return $pagename;

}


/**
 * Displays the page title
 *
 * @since       2.0
 * @param       $echo - whether or not to echo the title
 * @return      string
*/

function chp_page_title( $echo = true ) {

	global $post;

	if ( is_home() || is_single() ) {

		$title = get_the_title( get_option('page_for_posts', true) );

	} elseif ( is_category() || is_archive() ) {

		$title = sprintf('%s: %s', __('Posts for Category', 'chp'), single_cat_title('', false) );

	} elseif ( is_author() ) {

		$title = sprintf('%s: %s', __('Posts for Author', 'chp'), get_the_author_meta( 'display_name', get_query_var('author') ) );

	} elseif ( is_search() ) {

		$title = sprintf('%s: %s', __('Search Results For', 'chp'), $_GET['s'] );

	} elseif ( is_404() ) {

		$title = __('404 Error - Page not found', 'chp');

	} else {

		$title = get_the_title( $post->ID );

	}

	$title = apply_filters('chp-page-title', $title );

	if ( $echo == true )
		echo $title;
	else
		return $title;

}


/**
 * Displays the page tagline ( if it's set )
 *
 * @since       2.0
 * @param       $echo - whether or not to echo the tagline
 * @return      string
*/

function chp_page_tagline( $echo = true ) {

	if ( is_search() )
		return false;

	if ( is_category() || is_archive() )
		$tagline = strip_tags( category_description() );
	else
		$tagline = get_post_meta( get_the_ID(), 'chp-page-tagline', true );

	if ( empty($tagline) )
		return false;
		
	$tagline = apply_filters('chp-page-tagline', $tagline );

	if ( $echo == true )
		echo $tagline;
	else
		return $tagline;

}


/**
 * Displays the page thumbnail ( if it's set )
 *
 * @since       2.0
 * @param       $post_id - the post id
 * @param       $echo - whether or not to echo the thumbnail
 * @return      string
*/

function chp_page_thumbnail( $post_id = null, $echo = true ) {

	global $post;

	if ( is_null($post_id) && isset($post->ID) )
		$post_id = $post->ID;

	if ( ! has_post_thumbnail($post_id) )
		return false;

	$thumbnail = get_the_post_thumbnail( $post_id, 'chp-page-thumbnail' );

	if ( ! $thumbnail )
		return false;

	$thumbnail = sprintf( '<figure class="page-thumbnail">%s</figure>', $thumbnail );

	if ( $echo == true )
		echo $thumbnail;
	else
		return $thumbnail;

}


/**
 * Displays the site breadcrumbs
 *
 * @since       2.0
 * @return      string
*/

function chp_breadcrumbs( $separator = '&rarr;' ) {

	global $post;

	$items = array();

	$items[] = array(
		'text' => __('Home', 'chp'),
		'link' => get_bloginfo('url')
	);

	if ( is_home() || ( is_single() && get_post_type() == 'post' ) || is_author() ) {

		$post_id = get_option('page_for_posts');

		$items[] = array(
			'text' => get_the_title( $post_id ),
			'link' => get_permalink( $post_id )
		);

	}

	if ( is_archive() ) {

		$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy') );

		$items[] = array(
			'text' => $term->name,
			'link' => get_term_link( $term, get_query_var('taxonomy') ) 
		);

	}

	if ( is_category() || is_single() ) {

		$cat = get_the_category();

		if ( ! empty($cat) ) {

			// retrieve first
			$cat = reset($cat);

			$items[] = array(
				'text' => $cat->name,
				'link' => get_category_link( $cat->term_id ) 
			);

		}

	}

	if ( is_single() || is_page() ) {

		if ( $post->post_parent ) {

			$items[] = array(
				'text' => get_the_title( $post->post_parent ),
				'link' => get_permalink( $post->post_parent )
			);

		}

		$items[] = array(
			'text' => get_the_title( $post->ID ),
			'link' => get_permalink( $post->ID )
		);

	}

	if ( is_author() ) {

		$items[] = array(
			'text' => get_the_author_meta( 'display_name', get_query_var('author') )
		);

	}

	if ( is_search() ) {

		$items[] = array(
			'text' => __('Search Results', 'chp')
		);

	}

	if ( is_404() ) {

		$items[] = array(
			'text' => __('404 Error', 'chp')
		);

	}

	// Store the last key in the array
	end($items); $last = key($items);

	foreach ( $items as $key => $item ) {

		if ( isset($item['link']) && $key != $last )
			$output = sprintf('<li><a href="%s">%s</a></li>', $item['link'], $item['text'] );
		else
			$output = sprintf('<li>%s</li>', $item['text'] );

		$items[ $key ] = $output;

	}

	$separator = sprintf('<li>%s</li>', $separator );

	echo '<nav class="breadcrumbs">';
		echo implode( $separator, $items );
	echo '</nav>';

}


/**
 * Outputs the site's search form
 *
 * @since       2.0
 * @return      string
*/

function chp_search_form( $text = '' ) {

	if ( empty($text) )
		$text = __('Search', 'chp');

	printf(
		'<form id="search-form" method="get" action="%s">
			<input id="search" name="s" type="text" value="%s">
		</form>',
		get_bloginfo('url'),
		$text
	);
	
}


/**
 * Dynamic Sidebar
 *
 * If a sidebar is set to the current page from the theme metabox, then display it.
 * Otherwise, default to the primary theme sidebar ('Sidebar')
 *
 * @since       2.0 
 * @return      string
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
 * Outputs the site's copyright
 *
 * @since       2.0
 * @return      string
*/

function chp_copyright() {
		
	$year = date('Y');
	$name = get_bloginfo('name');

	$output = sprintf('%s &copy; Copyright %s', $name, $year );

	echo apply_filters( 'chp-copyright', $output, $name );

}


/**
 * Image
 *
 * Retrieves the image provided from the theme images directory. Will return false if the image was not found
 *
 * @since       2.0
 * @param       $filename - the image to retrieve
 * @param       $local    - whether or not the image is in the theme images directory
 * @param       $echo     - whether or not to echo the image
 * @return      string
*/

function chp_image( $filename, $local = true, $echo = true ) {

	$dir = ( $local == true ) ? THEME_IMAGES : CHP_IMAGES;

	if ( ! file_exists( $dir . $filename ) )
		return false;

	if ( $echo == true )
		echo $dir . $filename;
	else
		return $dir . $filename;
	
}


# END template.php
