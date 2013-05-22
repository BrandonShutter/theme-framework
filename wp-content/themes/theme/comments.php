<?php
/**
 * Displays posts comments by using a custom callback function
 *
 * @author 		CHP Advertising
 * @package 	CHP Theme Framework
 * @since       1.0
 */
?>

<section id="comments">

	<?php if ( comments_open() ): ?>

		<strong class="comments-number">
		<?php
			comments_number(
				sprintf('%s Comments', '<span class="highlight">0</span>'),
				sprintf('%s Comment',  '<span class="highlight">1</span>'),
				sprintf('%s Comments', '<span class="highlight">%</span>')
			);
		?>
		</strong>

		<?php if ( have_comments() ) : ?>

			<ul class="comments-list cf">
				<?php wp_list_comments( array( 'type' => 'comment', 'callback' => 'chp_comments_template' ) ); ?>
			</ul>

		<?php else: ?>

			<p class="no-results"><?php _e( apply_filters('chp-no-comments', 'There are currently no comments for this post.'), 'chp'); ?></p>

		<?php endif; ?>

	<?php else: ?>

		<p class="comments-closed-message"><?php _e( apply_filters('chp-closed-comments', 'Comments are currently closed for this post.'), 'chp'); ?></p>

	<?php endif; ?>

</section>

<?php get_template_part('comment-form'); ?>

