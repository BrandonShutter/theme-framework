<?php
/**
 *
 * The template for displaying a single post
 *
 * @author 		CHP Advertising
 * @package 	CHP Theme Framework
 * @version     1.0
 */
?>

<?php get_header(); ?>

<section class="content">

	<?php get_template_part('post-content-single'); ?>

</section>

<aside class="sidebar"> 

	<?php chp_dynamic_sidebar(); ?>

</aside>

<?php get_footer(); ?>