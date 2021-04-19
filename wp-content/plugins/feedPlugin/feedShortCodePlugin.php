<?php
/**
 * @package None
 */
/*
Plugin Name: Rss Feed Shortcode
Plugin URI: N/A
Description: The shortcode plugin will output blog feeds from konstructdigital.com when used on a page
Author: Rahul Shial
Author URI: https://github.com/rahulshial
License: GPLv2 or later
Text Domain: kd_feed
*/

include_once( ABSPATH . WPINC . '/feed.php' );

// Add Shortcode
function feedShortCode( $attr ) {

  shortcode_atts( array (
    'nbrOfFeed' => 1
  ), $attr);

  $feed = fetch_feed( 'https://www.konstructdigital.com/feed/' );

  if ( is_wp_error( $feed ) ) {
    $feed->enable_cache( true );
    $feed->set_cache_duration( 3600 );
  };

  $limit = $feed->get_item_quantity( $attr['nbrOfFeed'] ); //specify number of feeds
  $feedItems = $feed->get_items( 0, $limit ); // create an array of items
?>

  <h3>Number of Feeds = <?php echo $attr['nbrOfFeed'] ?></h3>

<?php
  foreach( $feedItems as $item ) {
    $categories = $item->get_category();
    foreach( $categories as $key => $categoryValue ) { 
      if ($key == 'term') {
        $category = $categoryValue;
      };
    };
  
    $authorArray = $item->get_author();
    foreach($authorArray as $authorKey => $authorValue) { 
      if( $authorKey == 'name' ) {
        $author = $authorValue;
      };
    };
  
    $pubDate = $item->get_date('F j, Y @ g:i a');
?>

  <div>
    <a  href="<?php echo $item->get_permalink(); ?>"
        title="<?php echo $item->get_date('F j, Y @ g:i a'); ?>">
        <?php echo $item->get_title(); ?>
    </a>
  </div>
  <span> <?php echo "Date: " . $pubDate; ?></span>
  <span> <?php echo "Author: " . $author; ?></span>
  <span> <?php echo "Category: " . $category; ?></span>
  <br></br>
<?php 
  }; 
?>

<?php

  // return $feedItems;
  // return $feed;
  // return str_repeat($feed, $attr['nbrOfFeed']);

};

add_shortcode( 'kd_feed', 'feedShortCode' );

?>