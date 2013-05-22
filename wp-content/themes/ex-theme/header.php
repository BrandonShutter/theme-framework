<?php
/**
 * 
 * Displays the theme header
 *
 * @author 		CHP Advertising
 * @package 	CHP Theme Framework
 * @version     1.0
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
	<link rel="shortcut icon" href="<?php chp_option('favicon'); ?>">

	<meta name="Revisit-after" content="10 days" />
	<meta name="Rating" content="general" />
	<meta name="Copyright" content="Copyright © <?php echo date('Y'); ?> CHP Advertising, all rights reserved" />
	<meta name="Contact-address" content="info@chpadvertising.com" />
	<meta name="Distribution" content="Global" />
	<meta name="Resource-type" content="document" />
	<meta name="Category" content="" />
	<?php wp_head(); ?>
	
	<?php chp_custom_css(); ?>

	<?php chp_analytics(); ?>

	<!--[if IE]><link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/style/css/ie.css"><![endif]-->
	<!--[if lt IE 9]><link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/style/css/ie8.css"><![endif]-->

	<!--[if lt IE 9]>
		<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/ie-specific/html5.js"></script>
		<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/ie-specific/selectivizr.min.js"></script>
	<![endif]-->

</head>
<body class="no-js <?php body_class(); ?>">

<header></header>

<?php 

	if ( has_nav_menu('Main Menu') )
	wp_nav_menu( array('theme_location' => 'Main Menu') );

?>

<!-- Begin Main Content -->
