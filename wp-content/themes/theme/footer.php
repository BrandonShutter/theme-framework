<?php
/**
 * Displays the theme footer
 *
 * @author 		CHP Advertising
 * @package 	CHP Theme Framework
 * @since       2.0
 */
?>

<?php

	/*
	 * Action Hook - Can be used to add items after the content
	 */

	do_action('chp-after-main-content');

?>

<!-- End Main Content -->

<footer></footer>

<?php 

	if ( has_nav_menu('Footer Menu') )
		wp_nav_menu( array('theme_location' => 'Footer Menu') );

?>

<!-- Footer Scripts -->
<?php wp_footer(); ?>
<!-- End Footer Scripts -->


</body>
</html>