<?php
/**
 * Theme Template Part - Post Content 
 *
 * @author 		CHP Advertising
 * @package 	CHP Theme Framework
 * @since       2.0
 */
?>

<?php query_posts( chp_main_query_args() ); ?>

<?php if (have_posts()): while (have_posts()): the_post(); ?>

	<article id="post-<?php the_ID(); ?>" class="post">

	</article>

<?php endwhile; else: ?>

	<p class="no-posts"><?php echo apply_filters('chp-no-posts', __('There are currently no posts. Please check back soon!', 'chp') ); ?></p>

<?php endif; ?>

<?php chp_pagination(); ?>

<?php wp_reset_query(); ?>