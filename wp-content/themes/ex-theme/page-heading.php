<?php
/**
 * Theme Template Part - Page Heading 
 *
 * Displays the page heading
 *
 * @author 		CHP Advertising
 * @package 	CHP Theme Framework
 * @version     1.0
 */

global $post;

if ( is_404() ):

	$title   = get_the_title( chp_get_option('404_page') );
	$tagline = get_post_meta( chp_get_option('404_page'), 'chp-tagline', true );

else:

	// is_home() is really a check to see if the current page is the blog page - confusing I know
	// All we're doing is showing the Blog Title and Tagline if the current page is the blog page or a post
	$title   = ( is_home() || is_single() || is_category() || is_tax() ) ? get_the_title( get_option('page_for_posts', true)) : get_the_title();
	$tagline = ( is_home() || is_single() || is_category() || is_tax() ) ? get_post_meta( get_option('page_for_posts', true), 'chp-page-tagline', true) : get_post_meta( $post->ID, 'chp-page-tagline', true);

endif; ?>

<section class="page-heading">

	<h2 class="title"><?php echo apply_filters('chp-page-title', $title ); ?></h2>
	<h4 class="tagline"><?php echo apply_filters('chp-page-tagline', $tagline ); ?></h4>

</section><!-- End Page Heading -->