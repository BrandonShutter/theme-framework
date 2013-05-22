/*
 This function takes the shortcode that the user has selected
 in the popup window, and inserts it into the editor
*/


function embedshortcode() {
	
	var shortcodetext;
	var style = document.getElementById('shortcode_panel');
	

	if ( style.className.indexOf('current') != -1 ) {

		var selected_shortcode = document.getElementById('style_shortcode').value;

		if ( selected_shortcode == 0 )
			tinyMCEPopup.close();
		

		// -----------------------------
		// 	General
		// -----------------------------

		if ( selected_shortcode == 'note' ) {
			shortcodetext = '[note]Content goes here..[/note]';
		}

		if ( selected_shortcode == 'callout' ) {
			shortcodetext = '[callout link="" link_text=""]Content goes here..[/callout]';
		}

		if ( selected_shortcode == 'separator' ) {
			shortcodetext = '[separator]';
		}

		if ( selected_shortcode == 'image' ) {
			shortcodetext = '[image src="" class="" alt=""]';
		}

		if ( selected_shortcode == 'large-image' ) {
			shortcodetext = '[image src="" class="large" alt=""]';
		}

		if ( selected_shortcode == 'left-image' ) {
			shortcodetext = '[image src="" class="align-left" alt=""]';
		}

		if ( selected_shortcode == 'right-image' ) {
			shortcodetext = '[image src="" class="align-right" alt=""]';
		}

		// -----------------------------
		// 	Headings
		// -----------------------------

		if ( selected_shortcode == 'heading' ) {
			shortcodetext = '[heading]Content goes here..[/heading]';
		}

		if ( selected_shortcode == 'h1' ) {
			shortcodetext = '[h1]Content goes here..[/h1]';
		}

		if ( selected_shortcode == 'h2' ) {
			shortcodetext = '[h2]Content goes here..[/h2]';
		}

		if ( selected_shortcode == 'h3' ) {
			shortcodetext = '[h3]Content goes here..[/h3]';
		}

		if ( selected_shortcode == 'h4' ) {
			shortcodetext = '[h4]Content goes here..[/h4]';
		}

		if ( selected_shortcode == 'h5' ) {
			shortcodetext = '[h5]Content goes here..[/h5]';
		}

		if ( selected_shortcode == 'h6' ) {
			shortcodetext = '[h6]Content goes here..[/h6]';
		}

		// -----------------------------
		// 	Lists
		// -----------------------------

		if ( selected_shortcode == 'checklist' ) {
			shortcodetext = '[checklist]<br/>[item]Content goes here..[/item]<br/>[item]Content goes here..[/item]<br/>[item]Content goes here..[/item]<br/>[/checklist]';
		}

		if ( selected_shortcode == 'list-item' ) {
			shortcodetext = '[item]Content goes here..[/item]';
		}

		// -----------------------------
		// 	Other
		// -----------------------------

		if ( selected_shortcode == 'services' ) {
			shortcodetext = '[chp_services]<br/>[service id="" heading=""]Content goes here..[/service]<br/>[service id="" heading=""]Content goes here..[/service]<br/>[service id="" heading=""]Content goes here..[/service]<br/>[/chp_services]';
		}

		if ( selected_shortcode == 'specials' ) {
			shortcodetext = '[chp_specials amount="10"]';
		}

		if ( selected_shortcode == 'recent-projects' ) {
			shortcodetext = '[chp_recent_projects heading="" cat="" limit="10"]';
		}

		if ( selected_shortcode == 'newsletter' ) {
			shortcodetext = '[chp_newsletter]';
		}

		if ( selected_shortcode == 'team-members' ) {
			shortcodetext = '[chp_team heading=""]<br/>[member name="" position=""]Content goes here..[/member]<br/>[member name="" position=""]Content goes here..[/member]<br/>[member name="" position=""]Content goes here..[/member]<br/>[/chp_team]';
		}

	}

	//

	if ( window.tinyMCE ) {

		window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, shortcodetext);
		tinyMCEPopup.editor.execCommand('mceRepaint');
		tinyMCEPopup.close();

	}

	return;

}




