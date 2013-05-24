<?php
/**
 * Template Name: Homepage
 *
 * @author 		CHP Advertising
 * @package 	CHP Theme Framework
 * @since       2.0
 */
?>

<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	

<?php endwhile; endif; ?>

<?php get_footer(); ?>