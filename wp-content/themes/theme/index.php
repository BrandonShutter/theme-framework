<?php
/**
 * Template Name: Blog
 *
 * @author 		CHP Advertising
 * @package 	CHP Theme Framework
 * @since       2.0
 */
?>

<?php get_header(); ?>

<section class="content">
	
	<?php get_template_part('content', 'post'); ?>

</section><!-- End Content -->

<aside class="sidebar">

	<?php chp_dynamic_sidebar(); ?>

</aside><!-- End Sidebar -->

<?php get_footer(); ?>