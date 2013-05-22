<?php
/**
 *
 * Template Name: Full Width
 *
 * @author 		CHP Advertising
 * @package 	CHP Theme Framework
 * @version     1.0
 */
?>

<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
	<?php the_content(); ?>

<?php endwhile; endif; ?>

<?php get_footer(); ?>