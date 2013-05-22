<?php
/**
 *
 * Theme Template Part - Single Post Content 
 *
 * The template for displaying a single post's content
 *
 * @author 		CHP Advertising
 * @package 	CHP Theme Framework
 * @version     1.0
 */
?>

<?php if (have_posts()): while (have_posts()): the_post(); ?>

<article id="<?php the_ID(); ?>">

	

</article>

<?php endwhile; endif; ?>