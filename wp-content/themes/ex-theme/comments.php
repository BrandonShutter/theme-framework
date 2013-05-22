<?php
/**
 * 
 * Displays posts comments by using a custom callback function
 *
 * @author 		CHP Advertising
 * @package 	CHP Theme Framework
 * @version     1.0
 */
?>

<section id="comments">
			
	<strong class="amount">
	<?php
		comments_number(
			sprintf('%s Comments', '<span class="highlight">0</span>'),
			sprintf('%s Comment',  '<span class="highlight">1</span>'),
			sprintf('%s Comments', '<span class="highlight">%</span>')
		);
	?>
	</strong>

	<?php if ( have_comments() && comments_open() ) : ?>

		<ul class="comments-container cf">
			<?php wp_list_comments( array( 'type' => 'comment', 'callback' => 'chp_comments_template' ) ); ?>
		</ul>

	<?php else: ?>

		<strong class="no-comments">There are currently no comments.</strong>

	<?php endif; ?>

</section>

<?php get_template_part('comment-form'); ?>

