<?php
/**
 * The template for displaying 404 errors
 *
 * @author 		CHP Advertising
 * @package 	CHP Theme Framework
 * @since       1.0
 */
?>

<?php get_header(); ?>

<section class="page-not-found">
	
	<p>
		<?php echo apply_filters( 'chp-404-error', __('The page you were looking for could not be found. Please check the URL you have entered, and then try again.', 'chp') ); ?>
	</p>

	<?php do_action('chp-404-page'); ?>

</section>

<?php get_footer(); ?>