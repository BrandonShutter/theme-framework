<?php
/**
 * Default Page Template
 *
 * @author 		CHP Advertising
 * @package 	CHP Theme Framework
 * @since       1.0
 */
?>

<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<section class="content">
	
	<?php the_content(); ?>

	<?php

		/*
		 * Action Hook - Can be used to add items after the content
		 */

		do_action('chp-after-content');

	?>

</section><!-- End Content -->

<aside class="sidebar">

	<?php chp_dynamic_sidebar(); ?>

	<?php

		/*
		 * Action Hook - Can be used to add items after the sidebar
		 */

		do_action('chp-after-sidebar');

	?>

</aside><!-- End Sidebar -->

<?php endwhile; endif; ?>

<?php get_footer(); ?>