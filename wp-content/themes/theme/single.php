<?php
/**
 * The template for displaying a single post
 *
 * @author 		CHP Advertising
 * @package 	CHP Theme Framework
 * @since       1.0
 */
?>

<?php get_header(); ?>

<section class="content">

	<?php get_template_part('content', 'single-post'); ?>

	<?php

		/*
		 * Action Hook - Can be used to add items after the content
		 */

		do_action('chp-after-content');

	?>

</section>

<aside class="sidebar"> 

	<?php chp_dynamic_sidebar(); ?>

	<?php

		/*
		 * Action Hook - Can be used to add items after the sidebar
		 */

		do_action('chp-after-sidebar');

	?>

</aside>

<?php get_footer(); ?>