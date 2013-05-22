<?php
/**
 * Displays the theme header
 *
 * @author 		CHP Advertising
 * @package 	CHP Theme Framework
 * @since       1.0
 */
?>
<!DOCTYPE html>

<!--[if IE 8]><html lang="eng" class="ie-8"><![endif]-->
<!--[if gt IE 9]><html lang="eng"><![endif]-->

<head>	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<!-- Site Title -->
	<title><?php wp_title(); ?></title>

	<!-- Favicon -->
	<link rel="shortcut icon" href="<?php chp_image('favicon.png'); ?>">

	<meta name="Revisit-after" content="5 days" />
	<meta name="Rating" content="general" />
	<meta name="Copyright" content="Copyright © <?php echo date('Y'); ?> CHP Advertising, all rights reserved" />
	<meta name="Contact-address" content="info@chpadvertising.com" />
	<meta name="Distribution" content="Global" />
	<meta name="Resource-type" content="document" />

	<?php

		wp_head();
		chp_custom_css();
		chp_analytics();

	?>

</head>
<body <?php body_class('no-js'); ?>>

<header></header>

<?php 

	if ( has_nav_menu('Main Menu') )
		wp_nav_menu( array('theme_location' => 'Main Menu') );

?>

<!-- Begin Main Content -->

<?php

	/*
	 * Action Hook - Can be used to add items before the content
	 */

	do_action('chp-before-main-content');

?>
