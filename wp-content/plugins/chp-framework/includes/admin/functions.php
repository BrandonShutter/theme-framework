<?php
/**
 * Admin Functions
 *
 * @package     CHP Framework
 * @copyright   Copyright (c) 2013, CHP Advertising
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0 
*/

// Exit if accessed directly
if ( ! defined('ABSPATH') ) exit;

/**
 * Update Content Links
 *
 * First we check to see if the site url has been updated. If it has, then we
 * update links located in all post types to be based off the new url. We
 * also flush the rewrite rules to reset all links ( permalinks included )
 *
 * @since       1.0
 * @return      void
*/

function chp_update_content_links() {

    if ( ! isset($_POST['action']) || $_POST['action'] != 'update' )
        return false;

    $new_url = $_POST['siteurl'];
    $old_url = get_option('siteurl');

    if ( $new_url != $old_url ) {

        $posts = get_posts( array('post_type' => 'any', 'posts_per_page' => -1) );

        if ( ! $posts )
            return false;

        foreach ( $posts as $post ) {

            wp_update_post( array(
                'ID' => $post->ID,
                'post_content' => str_replace( $old_url, $new_url, $post->post_content )
            ));

        }

        flush_rewrite_rules();

    }

} add_action('load-options.php', 'chp_update_content_links');


# END functions.php
