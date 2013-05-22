<?php
/**
 * The template for displaying 404 errors
 *
 * @author 		CHP Advertising
 * @package 	CHP Theme Framework
 * @version     1.0
 */
?>

<?php get_header(); ?>

<section class="content">

	<section class="primary container">
	
	<?php echo get_post_field('post_content', chp_get_option('404_page') ); ?>

	</section>

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