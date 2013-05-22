<?php
/**
 * Theme Template Part - Comment Form
 *
 * @author 		CHP Advertising
 * @package 	CHP Theme Framework
 * @since       1.0
 */
?>

<form id="comment-form" action="<?php echo site_url('wp-comments-post.php'); ?>" method="post">

	<div class="form-heading">
		<h5 id="respond"><?php comment_form_title( 'Leave a Comment', 'Reply to %s') ?></h5>
		<p><?php _e('Privacy is important to us, and your email address will never be published.', 'chp'); ?></p>
	</div>

	<div class="form-content">

		<?php if ( $user_ID ): ?>

			<?php global $user_identity; ?>

			<p class="logged-in-as"><?php _e('Logged in as', 'chp'); ?> <a href="<?php echo site_url('/wp-admin/profile.php'); ?>"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url( get_permalink() ); ?>" title="<?php _e('Log out of this account', 'chp'); ?>"><?php _e('Log out', 'chp'); ?> &rarr;</a></p>

		<?php else: ?>

			<div class="form-field required">
				<input id="author" type="text" name="author" value="<?php _e('Your Name', 'chp'); ?>">
			</div>
			<div class="form-field required">
				<input id="email" type="text" name="email" value="<?php _e('Your Email', 'chp'); ?>">
			</div>
			<div class="form-field">
				<input id="website" type="text" name="url" value="<?php _e('Your Website', 'chp'); ?>">
			</div>

		<?php endif; ?>
			
		<div class="form-field required">
			<textarea id="comment" name="comment"><?php _e('Your Message', 'chp'); ?></textarea>
		</div>

		<div class="form-submit">
			<input id="submit" class="button" type="submit" name="submit" value="Submit Comment">
			<span class="moderation-notice"><?php _e('All comments will go through moderation before being posted.', 'chp'); ?></span>
		</div>
		
		<?php comment_id_fields(); ?>
		<?php do_action( 'comment_form', $post->ID ); ?>

	</div>

</form>
