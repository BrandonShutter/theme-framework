<?php
/**
 * Twitter Widget
 *
 * @package     CHP Framework
 * @copyright   Copyright (c) 2013, CHP Advertising
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       2.0 
*/

// Exit if accessed directly
if ( ! defined('ABSPATH') ) exit;


class CHP_Twitter_Widget extends CHP_Widget {

	var $tweets = array();

	function __construct() {

		$this->options = array(
			'name'        => 'CHP - Twitter Feed', 
			'description' => __('Displays recent tweets from the twitter username set in the options panel.', 'chp'),
			'class'       => 'twitter'     
		);

		$this->defaults = array(
			'widget_title' => 'Recent Tweets',
			'tweet_count'  => '2'
		);

		parent::__construct();

	}


	function fields( $instance ) {

		extract($instance);

		// Amount of Tweets ?>

		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>" style="display: block;">Tweets Amount</label>
			<input
				id="<?php echo $this->get_field_id('number'); ?>"
				name="<?php echo $this->get_field_name('number'); ?>"
				value="<?php echo ( isset($number) && !empty($number) ) ? $number : $this->defaults['tweet_count']; ?>"
				style="width: 50px;"
				type="number"
			/>
		</p>

		<?php

	}


	function content( $instance ) {

		extract($instance);

		$this->tweets( $number );

		if ( $this->has_tweets() ): foreach ( $this->tweets as $tweet ): ?>

		<article class="tweet">
			<p><?php echo $tweet['body']; ?></p>
			<span class="date"><?php echo $tweet['date']; ?></span>
		</article>

		<?php endforeach; else: ?>

		<p class="no-tweets"><?php _e('There are currently no tweets to be displayed.', 'chp'); ?></p>

		<?php endif;

	}


	function tweets( $count = 2 ) {

		$username = chp_option('twitter');

		// The Twitter username has not been set
		if ( ! $username )
			return false;

		// All we're doing here is checking to see if there are cached tweets already in the database
		// If there are no cached tweets, then we simply query the Twitter API for the most recent tweets
		$this->tweets = ( get_transient('chp-tweets') ) ? get_transient('chp-tweets') : $this->get_tweets( $username, $count );

	}


	function get_tweets( $username, $count = 2 ) {

		$tweets = wp_remote_get("https://api.twitter.com/1/statuses/user_timeline.rss?screen_name=$username");

		// There was an error with retrieving the data from Twitter
		if ( is_wp_error($tweets) || isset($tweets->errors) || empty($tweets['body']) )
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

		return ( ! empty($this->tweets) ) ? true : false;

	}


	function anchorize( $tweet ) {

		$tweet = preg_replace('/(http[^\s]+)/im', '<a href="$1" target="_blank">$1</a>', $tweet );

		return $tweet;

	}


	function convert( $tweet_date ) {

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


# END widget-twitter.php
