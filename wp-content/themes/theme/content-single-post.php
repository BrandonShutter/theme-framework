<?php
/**
 * Theme Template Part - Single Post Content 
 *
 * @author 		CHP Advertising
 * @package 	CHP Theme Framework
 * @since       1.0
 */
?>

<?php if (have_posts()): while (have_posts()): the_post(); ?>

<article id="post-<?php the_ID(); ?>" class="single-post">

	

</article>

<?php endwhile; endif; ?>