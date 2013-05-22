<?php
/**
 *
 * Theme Template Part - Post Content 
 *
 * The template for displaying posts in a loop
 *
 * @author 		CHP Advertising
 * @package 	CHP Theme Framework
 * @version     1.0
 */
?>

<?php

$args = apply_filters('chp-post-loop-args', array(
	'post_type'      => 'post',
	'cat'            => ( chp_get_option('blog_category') )  ? chp_get_option('blog_category')  : 1,
	'posts_per_page' => ( chp_get_option('posts_per_page') ) ? chp_get_option('posts_per_page') : 10,
	'paged'          => ( get_query_var('paged') ) ? get_query_var('paged') : 1,
));

query_posts( $args ); ?>

<?php if (have_posts()): while (have_posts()): the_post(); ?>

	


<?php endwhile; else: ?>

	<p class="no-posts"><?php echo apply_filters('chp-no-posts', __('We were unable to find any posts', 'chp') ); ?></p>

<?php endif; ?>

<?php chp_pagination(); ?>

<?php wp_reset_query(); ?>