<?php
/**
 * Metabox Page Tagline
 *
 * @package     CHP Framework
 * @copyright   Copyright (c) 2013, CHP Advertising
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0  
*/

// Exit if accessed directly
if ( ! defined('ABSPATH') ) exit;


class CHP_Page_Tagline_Metabox extends CHP_Metabox {

	function __construct() {

		$this->args = array(
			'title' => 'Page Tagline',
			'post_type' => 'page',
			'context' => 'side',
			'priority' => 'default'
		);

		$this->fields = array(
			'page-tagline'
		);

		parent::__construct();

	}

	function output( $post ) {

		$value = get_post_meta($post->ID, 'chp-page-tagline', true);

		printf('<textarea class="widefat" name="%s" rows="5">%s</textarea>', 'chp-page-tagline', $value );

	}

}


# END metabox-page-tagline.php
