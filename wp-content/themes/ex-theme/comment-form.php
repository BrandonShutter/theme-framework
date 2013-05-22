<?php
/**
 * Theme Template Part - Comment Form
 *
 * Displays the comment form for posts
 *
 * @author 		CHP Advertising
 * @package 	CHP Theme Framework
 * @version     1.0
 */
?>

<form id="comment-form" class="form" action="<?php echo site_url('wp-comments-post.php'); ?>" method="post">

	<h5 id="respond"><?php comment_form_title( 'Leave a Comment', 'Reply to %s') ?></h5>

	<p>Privacy is important to us, and your email address will never be published.</p>

	<?php if ( $user_ID ): ?>

		<?php global $user_identity; ?>

		<p>Logged in as <a href="<?php echo site_url('/wp-admin/profile.php'); ?>"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url( get_permalink() ); ?>" title="Log out of this account">Log out &rarr;</a></p>

	<?php else: ?>

		<div class="required"><input id="author" type="text" name="author" value="Your Name"></div>
		<div class="required"><input id="email" type="text" name="email" value="Your Email"></div>
		<div><input id="website" type="text" name="url" value="Your Website"></div>

	<?php endif; ?>
		
	<div class="required textarea"><textarea id="comment" name="comment" value="Your Message">Your Message</textarea></div>

	<input id="submit" class="button" type="submit" name="submit" value="Submit Comment">
	<?php comment_id_fields(); ?>

	<span class="message">All comments will go through moderation before being posted.</span>

	<?php do_action( 'comment_form', $post->ID ); ?>

</form>
