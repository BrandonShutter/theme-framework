<?php
/**
 *
 * Default Page Template
 *
 * @author 		CHP Advertising
 * @package 	CHP Theme Framework
 * @version     1.0
 */
?>

<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<section class="content">
	
	<?php the_content(); ?>

	<?php

		/*
		 * Action Hook - Can be used to add more items to the content area
		 */

		do_action('chp-after-content');

	?>

</section><!-- End Content -->

<aside class="sidebar">

	<?php chp_dynamic_sidebar(); ?>

</aside><!-- End Sidebar -->

<?php endwhile; endif; ?>

<?php get_footer(); ?>