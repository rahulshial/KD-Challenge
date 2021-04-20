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
?>
<style><?php include('./styles/style.css'); ?></style>

<?php
function getFeeds( $count ) {

  $feed = fetch_feed( 'https://www.konstructdigital.com/feed/' );

  if ( is_wp_error( $feed ) ) {
    $feed->enable_cache( true );
    $feed->set_cache_duration( 3600 );
  };

  $limit = $feed->get_item_quantity( $count ); //specify number of feeds
  $feedItems = $feed->get_items( 0, $limit ); // create an array of items
?>
<div>
    <style>
  /* ::before */
  .feed-container {
    display:flex;
    flex-wrap:wrap;
    justify-content:space-between;
    max-width:1200px;
    margin:auto;
    padding:0
  }

  .feed-item {
    display: block;
    width: 33%;
    margin: 20px 0;
    background-color: #fff;
    word-break: break-word;
    overflow: hidden;
    box-shadow: 0 11px 15px 0 rgba(0,0,0,.13);
  }

  h3 {
    font-family: Verdana; 
    color: red;
  }
    </style>
  <h3>Number of Feeds = <?php echo $count ?></h3>
  <div class='feed-container'>
<?php
  foreach( $feedItems as $item ) {
    $pubDate = $item->get_date('F j, Y');
    $title = $item->get_title();
    $titleDate = $item->get_date('F j, Y @ g:i a');
    $permaLink = $item->get_permalink();
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
?>
    <div class='feed-item'>
      <a class="image-container" href=<?php echo $permaLink ?>>
          <img width="1230" height="615" src="https://www.konstructdigital.com/wp-content/uploads/2021/03/blog-post-microcopy-banner.png" class="feed-post__image wp-post-image" alt="An image" loading="lazy" srcset="https://www.konstructdigital.com/wp-content/uploads/2021/03/blog-post-microcopy-banner.png 1230w, https://www.konstructdigital.com/wp-content/uploads/2021/03/blog-post-microcopy-banner-300x150.png 300w, https://www.konstructdigital.com/wp-content/uploads/2021/03/blog-post-microcopy-banner-1024x512.png 1024w, https://www.konstructdigital.com/wp-content/uploads/2021/03/blog-post-microcopy-banner-768x384.png 768w" sizes="(max-width: 1230px) 100vw, 1230px">
      </a>
      <div class='feed-item-text-container'>
        <p class='feed-date'>
          <time class='feed-published'><?php echo $pubDate ?></time>
        </p>
        <h3>
          <a class='feed-link' href=<?php echo $permaLink ?> title=<?php echo $titleDate ?>><?php echo $title ?></a>
        </h3>
        <p class='feed-metaData'>
          <span class='feed-category'><?php echo $category; ?></span>
          <span class='feed-author'><?php echo " * " . $author; ?></span>
        </p>
      </div>
    </div>
<?php 
  }; 
?>
  </div>
</div>
<?php 
};
?>

<?php
function feedShortCode( $attr ) {
  shortcode_atts( array (
    'repeat' => 1
  ), $attr);

  return getFeeds( $attr['repeat'] );
};
?>

<?php
add_shortcode( 'kd_feed', 'feedShortCode' );
?>