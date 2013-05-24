<?php
/**
 * Metabox Page Sidebar
 *
 * @package     CHP Framework
 * @copyright   Copyright (c) 2013, CHP Advertising
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       2.0  
*/

// Exit if accessed directly
if ( ! defined('ABSPATH') ) exit;


class CHP_Page_Sidebar_Metabox extends CHP_Metabox {

	function __construct() {

		$this->args = array(
			'title' => 'Page Sidebar',
			'post_type' => 'page',
			'context' => 'side',
			'priority' => 'default'
		);

		$this->fields = array(
			'page-sidebar'
		);

		parent::__construct();

	}

	function output( $post ) {

		$value = get_post_meta($post->ID, 'chp-page-sidebar', true); ?>

		<select class="widefat" type="text" name="%s" value="%s">

			<option value="none-selected"><?php _e('-- Select a Sidebar --', 'chp'); ?></option>

			<?php foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ): ?>

				<option value="<?php echo ucwords( $sidebar['name'] ); ?>" <?php selected( $sidebar['name'], $value ); ?>>
					<?php echo ucwords( $sidebar['name'] ); ?>
				</option>

			<?php endforeach; ?>

		</select>

		<?php

	}

}


# END metabox-page-sidebar.php
