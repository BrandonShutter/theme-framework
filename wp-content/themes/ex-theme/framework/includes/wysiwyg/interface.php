<?php require_once('config.php');

if ( !is_user_logged_in() || !current_user_can('edit_posts') )
	wp_die(__("You are not allowed to be here","truethemes"));

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Shortcodes</title>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php echo get_option('blog_charset'); ?>" />
<script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/framework/wysiwyg/wysiwyg.js"></script>
<script type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
<base target="_self" />
</head>

<body onLoad="tinyMCEPopup.executeOnLoad('init();');document.body.style.display='';" style="display: none" id="link">

<form name="karma_shortcode_form" action="#">
<div style="height:100px;width:250px;margin:0 auto;padding-top:50px;text-align:center;" class="shortcode_wrap">
<div id="shortcode_panel" class="current" style="height:50px;">
<fieldset style="border:0;width:100%;text-align:center;">
<select id="style_shortcode" name="style_shortcode" style="width:250px">

<option value="0">Select a Shortcode...</option>
<option value="0"> </option>

<?php // Headings ?>
<option value="0" style="font-weight:bold;font-style:italic;">--- General ---</option>
<option value="note">Note</option>
<option value="callout">Callout</option>
<option value="separator">Separator</option>
<option value="image">Image</option>
<option value="large-image">Large Image</option>
<option value="left-image">Left Image</option>
<option value="right-image">Right Image</option>

<option value="0"> </option>

<?php // Headings ?>
<option value="0" style="font-weight:bold;font-style:italic;">--- Headings ---</option>
<option value="heading">Heading</option>
<option value="h1">H1</option>
<option value="h2">H2</option>
<option value="h3">H3</option>
<option value="h4">H4</option>
<option value="h5">H5</option>
<option value="h6">H6</option>

<option value="0"> </option>

<?php // Lists ?>
<option value="0" style="font-weight:bold;font-style:italic;">--- Lists ---</option>
<option value="checklist">Checklist</option>
<option value="list-item">List Item</option>

<option value="0"> </option>

<?php // Other ?>
<option value="0" style="font-weight:bold;font-style:italic;">--- Other ---</option>
<option value="services">Services</option>
<option value="specials">Specials</option>
<option value="recent-projects">Recent Projects</option>
<option value="newsletter">Newsletter</option>
<option value="team-members">Team Members</option>

<option value="0"> </option>


</select>
</fieldset>
</div><!-- end shortcode_panel -->

<div style="float:left"><input type="button" id="cancel" name="cancel" value="<?php echo "Close"; ?>" onClick="tinyMCEPopup.close();" /></div>
<div style="float:right"><input type="submit" id="insert" name="insert" value="<?php echo "Insert"; ?>" onClick="embedshortcode();" /></div>

</div><!-- end shortcode_wrap -->
</form>

</body>
</html>