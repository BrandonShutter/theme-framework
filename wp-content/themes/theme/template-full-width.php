<?php
/**
 * Template Name: Full Width
 *
 * @author 		CHP Advertising
 * @package 	CHP Theme Framework
 * @since       1.0
 */
?>

<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
	<section class="full-width">
		
		<?php the_content(); ?>
		
		<?php

		/*
		 * Action Hook - Can be used to add items after the content
		 */

		do_action('chp-after-content');

	?>

	</section>

<?php endwhile; endif; ?>

<?php get_footer(); ?>