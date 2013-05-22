<?php
/**
 *
 * Template Name: Blog
 *
 * @author 		CHP Advertising
 * @package 	CHP Theme Framework
 * @version     1.0
 */
?>

<?php get_header(); ?>

<section class="content">
	
	<?php get_template_part('post-content'); ?>

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

<?php get_footer(); ?>