<?php
/**
 * Displays the post comments content
 *
 * @author 		CHP Advertising
 * @package 	CHP Theme Framework
 * @since       1.0
 */
?>

<li id="comment-<?php comment_ID(); ?>" class="comment">
	<div class="comment-heading">
		<strong class="name"><?php comment_author_link(); ?></strong>
		<span class="date"><?php printf( '%s at %s', get_comment_date(), get_comment_time() ); ?></span>
	</div>
	<div class="comment-content">
		<?php if ( $GLOBALS['comment']->comment_approved == '0' ): ?>
			<p><?php _e( apply_filters('chp-comment-awaiting-approval', 'Your comment is awaiting approval. Please check back soon!'), 'chp'); ?></p>
		<?php else: ?>
			<?php comment_text(); ?>
		<?php endif; ?>
	</div>
	<?php comment_reply_link( array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']) ) ); ?>
</li>