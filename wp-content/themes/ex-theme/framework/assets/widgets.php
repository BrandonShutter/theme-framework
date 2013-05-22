<?php
/**
 * Widgets
 *
 * @package     CHP Advertising Theme Framework
 * @subpackage  widget functions
 * @copyright   Copyright (c) 2013, CHP Advertising
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0 
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Register Widgets
 *
 * Registers all theme widgets
 *
 * @access      private
 * @since       1.0 
 * @return      void
*/

function chp_register_widgets() {

	// Sidebar Widgets
	//register_widget('');

	// Footer Widgets
	register_widget('chp_recent_posts');
	register_widget('chp_facebook');
	register_widget('chp_twitter');

	/*
	 * Action Hook - Can be used to add additional widgets to the theme
	 */

	do_action('chp-register-widgets');

}

add_action('widgets_init', 'chp_register_widgets');


/**
 * Add Widget Class
 *
 * Adds a class to the widget container provided
 *
 * @access      private
 * @since       1.0
 * @param       $class
 * @param       $target
 * @return      string
*/

function chp_add_widget_class( $class, $target ) {

	$regex = '#class="[^"]*#';

	preg_match( $regex, $target, $match ); // match becomes a variable of its own

	$target = preg_replace( $regex, $match[0] . $class, $target );

	return $target;

}


/* ----------------------------------------------------------------------- *|
/* ------ Sidebar Widgets ------------------------------------------------ *|
/* ----------------------------------------------------------------------- */



/* ----------------------------------------------------------------------- *|
/* ------ Footer Widgets ------------------------------------------------- *|
/* ----------------------------------------------------------------------- */


class chp_recent_posts extends WP_Widget {

	function __construct() {

		$this->options = array(
			'widget_name' => 'Recent Posts',
			'class' => ' latest-news',
			'description' => __('Displays recent posts from the blog category set in the theme options panel by default. The category can be overrided to display a custom query.'),
			'posts_count' => '2' 
		);

		parent::__construct('chp-recent-posts', 'CHP - Recent Posts', $this->options );

	}

	function form( $instance ) {

		extract( $instance );

		?>

		<?php // Widget Title ?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title</label>
			<input
				id="<?php echo $this->get_field_id('title'); ?>"
				name="<?php echo $this->get_field_name('title'); ?>"
				value="<?php echo ( isset($title) && !empty($title) ) ? esc_attr($title) : $this->options['widget_name']; ?>"
				class="widefat"
				type="text"
			/>
		</p>

		<?php // Amount of Posts ?>

		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>" style="display: block;">Posts Amount</label>
			<input
				id="<?php echo $this->get_field_id('number'); ?>"
				name="<?php echo $this->get_field_name('number'); ?>"
				value="<?php echo ( isset($number) && !empty($number) ) ? $number : $this->options['posts_count']; ?>"
				style="width: 50px;"
				type="number"
			/>
		</p>

		<?php
	}

	function widget( $args, $instance ) {

		extract( $args );
		extract( $instance );

		$before_widget = chp_add_widget_class( $this->options['class'], $before_widget );

		$title = ( !empty($title) ) ? apply_filters('widget_title', $title) : $this->options['widget_name'];

		echo $before_widget;

			echo $before_title;
				echo $title;
			echo $after_title;

		?>

		<?php

		$this->get_posts( $number );

		?>

		<?php if ( $this->has_posts() ): foreach ( $this->posts as $post ): ?>

		<a class="post" href="<?php echo get_permalink( $post->ID ); ?>"><?php echo $post->post_title; ?></a>

		<?php endforeach; else: ?>

		<p class="no-posts">We were unable to find any posts.</p>

		<?php endif; ?>

		<?php
		
		echo $after_widget;

	}

	function get_posts( $number = 2 ) {

		$category = chp_get_option('blog_category');

		$args = apply_filters('chp-recent-posts-args', array(
			'cat' => ( $category ) ? $category : 1,
			'posts_per_page' => $number,
		));

		$this->posts = get_posts( $args );

	}

	function has_posts() {

		return ( isset($this->posts) && !empty($this->posts) && is_array($this->posts) ) ? true : false;

	}

}




class chp_facebook extends WP_Widget {

	function __construct() {

		$this->options = array(
			'widget_name' => 'Facebook Feed',
			'class' => ' facebook',
			'description' => __('Displays recent posts from the Facebook username set in the theme options panel.'),
			'posts_amount' => '2'
		);

		parent::__construct('facebook', 'CHP - Facebook Feed', $this->options);
	}

	function form( $instance ) {

		extract( $instance );

		?>

		<?php // Widget Title ?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title</label>
			<input
				id="<?php echo $this->get_field_id('title'); ?>"
				name="<?php echo $this->get_field_name('title'); ?>"
				value="<?php echo (isset($title) && !empty($title)) ? esc_attr($title) : $this->options['widget_name']; ?>"
				class="widefat"
				type="text"
			/>
		</p>

		<?php // Amount of Posts ?>

		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>" style="display: block;">Posts Amount</label>
			<input
				id="<?php echo $this->get_field_id('number'); ?>"
				name="<?php echo $this->get_field_name('number'); ?>"
				value="<?php echo ( isset($number) && !empty($number) ) ? $number : $this->options['posts_amount']; ?>"
				style="width: 50px;"
				type="number"
			/>
		</p>

		<?php // Display Like Button ?>

		<p>
			<label for="<?php echo $this->get_field_id('display_like_button'); ?>" style="display: block;">Display Like Button? ( check if yes )</label>
			<input
				id="<?php echo $this->get_field_id('display_like_button'); ?>"
				name="<?php echo $this->get_field_name('display_like_button'); ?>"
				value="1"
				style="width: 50px;"
				type="checkbox"
				<?php if ( isset($display_like_button) ) checked( $display_like_button, 1 ); ?>
			/>
		</p>

		<?php
	}

	function widget( $args, $instance ) {

		extract( $args ); extract( $instance );

		$before_widget = chp_add_widget_class( $this->options['class'], $before_widget );

		$title = ( !empty($title) ) ? apply_filters('widget_title', $title) : $this->options['widget_name'];

		echo $before_widget;

			echo $before_title;
				echo $title;
			echo $after_title;

		?>

		<?php

		$this->facebook( $number );

		?>

		<?php if ( $this->has_posts() ): foreach( $posts as $post ): ?>

		<div class="post">
			<p><?php echo $post['content']; ?></p>
			<span class="date"><?php echo $post['date']; ?></span>
		</div>

		<?php endforeach; else: ?>

		<p class="no-posts">We were unable to find any posts at this time.</p>

		<?php endif; ?>

		<?php if ( isset($display_like_button) && $display_like_button == true ): ?>

		<a href="<?php printf('http://facebook.com/%s', chp_get_option('facebook')); ?>" class="like-button" target="_blank">Like us on Facebook</a>

		<?php endif;
		
		echo $after_widget;

	}

	function facebook( $amount = 2 ) {

		$username = chp_get_option('facebook');

		// The Facebook username has not been set
		if ( ! $username )
			return false;

		// All we're doing here is checking to see if there are cached posted already in the database
		// If there are NOT any cached posts, then we simply query the Facebook API for the most recent posts
		$this->posts = (get_transient('chp-fb-posts')) ? get_transient('chp-fb-posts') : $this->get_posts( $username, $amount );

	}

	function get_posts( $username, $amount = 2 ) {

		$feed = wp_remote_get( sprintf('http://www.facebook.com/feeds/page.php?id=%s&format=atom10', $username) );

		if ( is_wp_error($feed) || isset($feed->errors) || !empty($feed->errors) )
			return false; // There was an error with retrieving the data from Facebook

		$feed = str_replace( array('<![CDATA[', ']]>'), '', $feed['body']); // Facebook likes to add [CDATA] around the content of the post for some reason, so we need to remove that
		$feed = new SimpleXMLElement($feed);
		$feed = $feed->entry;

		$posts = array();

		if ( !empty($feed) ):

			foreach( $feed as $entry ):

				if ( $amount-- == 0 )
					break;

				$post = array();

				$content = (string) $entry->content;
				$content = substr($content, 0, strpos($content, ' ', 120)) . '..'; // Cut the post down to 120 characters ( along with keeping the last word intact )

				$date = (string) $entry->published;

				$post['content'] = $this->anchorize($content);
				$post['date']    = $this->convert($date);

				$posts[] = $post;

			endforeach;

		endif;

		set_transient('chp-fb-posts', $posts, 60 * 30); // cache the data for 30 minutes ( 60 * 30 )

		return $posts;

	}

	function has_posts() {

		return ( isset($this->posts) && !empty($this->posts) && is_array($this->posts) ) ? true : false;

	}

	function anchorize( $post ) {

		$post = preg_replace('/(http[^\s]+)/im', '<a href="$1" target="_blank">$1</a>', $post);
		
		return $post;

	}

	function convert( $date = null ) {

		// get current time

		$a = strtotime('now');

		// get time tweet was made

		$b = strtotime($date);

		// compare current time to time tweet was made

		$c = $a - $b;

		$minute = 60;
		$hour   = $minute * 60;
		$day    = $hour * 24;
		$week   = $day * 7;

		if ( is_numeric($c) && $c > 0 ) {

			if ( $c < $day ) :

				// if the time is less than or equal to an hour, then use 'hour'
				// otherwise the time is less than 24 hours, so use 'hours'

				$output = ( $c <= $hour ) ? '1 hour ago' : floor($c / $hour) . 'hours ago';

			elseif ( $c > $day ) :

				// if the time is more than 24 but less than 48 hours, then use 'day'
				// otherwise, if it's over 48 hours, use 'days'

				$output = ( $c > $day * 2 ) ? floor($c / $day) . ' days ago' : floor($c / $day) . ' day ago';

			endif;

		}

		return $output;

	}
}


class chp_twitter extends WP_Widget {

	function __construct() {

		$this->options = array(
			'widget_name' => 'Recent Tweets',
			'class' => ' twitter',
			'description' => __('Displays recent tweets from the Twitter username set in the theme options panel.'),
			'tweet_count' => '2' 
		);

		parent::__construct('chp-twitter', 'CHP - Twitter Feed', $this->options );

	}

	function form( $instance ) {

		extract($instance);

		?>

		<?php // Widget Title ?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title</label>
			<input
				id="<?php echo $this->get_field_id('title'); ?>"
				name="<?php echo $this->get_field_name('title'); ?>"
				value="<?php echo ( isset($title) && !empty($title) ) ? esc_attr($title) : $this->options['widget_name']; ?>"
				class="widefat"
				type="text"
			/>
		</p>

		<?php // Amount of Tweets ?>

		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>" style="display: block;">Tweets Amount</label>
			<input
				id="<?php echo $this->get_field_id('number'); ?>"
				name="<?php echo $this->get_field_name('number'); ?>"
				value="<?php echo ( isset($number) && !empty($number) ) ? $number : $this->options['tweet_count']; ?>"
				style="width: 50px;"
				type="number"
			/>
		</p>

		<?php
	}

	function widget( $args, $instance ) {

		extract( $args );
		extract( $instance );

		$before_widget = chp_add_widget_class( $this->options['class'], $before_widget );

		$title = ( !empty($title) ) ? apply_filters('widget_title', $title) : $this->options['widget_name'];

		echo $before_widget;

			echo $before_title;
				echo $title;
			echo $after_title;

		?>

		<?php

		$this->tweets( $number );

		?>

		<?php if ( $this->has_tweets() ): foreach ( $this->tweets as $tweet ): ?>

		<article class="tweet">
			<p><?php echo $tweet['body']; ?></p>
			<span class="date"><?php echo $tweet['date']; ?></span>
		</article>

		<?php endforeach; else: ?>

		<p class="no-posts">There are currently no tweets to be displayed.</p>

		<?php endif;
		
		echo $after_widget;

	}

	function tweets( $count = 2 ) {

		$username = chp_get_option('twitter');

		// The Twitter username has not been set
		if ( ! $username )
			return false;

		// All we're doing here is checking to see if there are cached tweets already in the database
		// If there are NOT any cached tweets, then we simply query the Twitter API for the most recent tweets
		$this->tweets = ( get_transient('chp-tweets') ) ? get_transient('chp-tweets') : $this->get_tweets( $username, $count );

	}

	function get_tweets( $username, $count = 2 ) {

		$tweets = wp_remote_get("https://api.twitter.com/1/statuses/user_timeline.rss?screen_name=$username");

		if ( is_wp_error($tweets) )
			return false;

		// There was an error with retrieving the data from Twitter
		if ( isset($tweets->errors) || empty($tweets['body']) )
			return false; 

		$tweets = new SimpleXMLElement( $tweets['body'] );
		$tweets = $tweets->channel;

		$data = new stdClass();
		$data->tweets = array();

		foreach ( $tweets->item as $value ):

			if ( $count-- == 0 ) break;

			$tweet = array();

			$tweet['body']  = str_replace( $username . ': ', '', $this->anchorize( $value->title ) );
			$tweet['date']  = $this->convert( $value->pubDate );

			$data->tweets[] = $tweet;

		endforeach;
		
		set_transient('chp-tweets', $data->tweets, 60 * 30 ); // cache the data for 30 minutes ( 60 * 30 )

		return $data->tweets;

	}

	function has_tweets() {

		return ( isset($this->tweets) && !empty($this->tweets) && is_array($this->tweets) ) ? true : false;

	}

	function anchorize( $tweet ) {

		$tweet = preg_replace('/(http[^\s]+)/im', '<a href="$1" target="_blank">$1</a>', $tweet );
		$tweet = preg_replace('/(@[^\s]+)/i', '<a href="http://twitter.com/$1" target="_blank">$1</a>', $tweet );

		return $tweet;

	}

	function convert( $tweet_date = null ) {

		// get current time

		$a = strtotime('now');

		// get time tweet was made

		$b = strtotime($tweet_date);

		// compare current time to time tweet was made

		$c = $a - $b;

		$minute = 60;
		$hour   = $minute * 60;
		$day    = $hour * 24;
		$week   = $day * 7;

		if ( is_numeric($c) && $c > 0 ) {

			if ( $c < $day ) :

				// if the time is less than or equal to an hour, then use 'hour'
				// otherwise the time is less than 24 hours, so use 'hours'

				$output = ( $c <= $hour ) ? '1 hour ago' : floor($c / $hour) . ' hours ago';

			elseif ( $c > $day ) :

				// if the time is more than 24 but less than 48 hours, then use 'day'
				// otherwise, if it's over 48 hours, use 'days'

				$output = ( $c > $day * 2 ) ? floor($c / $day) . ' days ago' : floor($c / $day) . ' day ago';

			endif;

		}

		return $output;

	}

}





# END widgets.php
