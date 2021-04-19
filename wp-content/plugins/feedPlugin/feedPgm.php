<?php // Get RSS Feed(s)
  include_once( ABSPATH . WPINC . '/feed.php' ); 

  // Get a SimplePie feed object from the specified feed source.
  $feeds = fetch_feed( 'https://www.konstructdigital.com/feed/' );

  $maxitems = 0;

  if ( ! is_wp_error( $feeds ) ) : // Checks that the object is created correctly

      // Figure out how many total items there are, but limit it to 5. 
      $maxitems = $feeds->get_item_quantity( 7 ); 

      // Build an array of all the items, starting with element 0 (first element).
      $feed_items = $feeds->get_items( 0, $maxitems );

  endif;
  ?>

<?php if ( $maxitems == 0 ) : ?>
  <ul>
  <li><?php _e( 'No items', 'Konstruct Digital' ); ?></li>
  </ul>
    <?php else : ?>
    // Loop through each feed item and display each item as a hyperlink.
      <?php foreach ( $feed_items as $item ) : 
        echo '<div class="rss-feed-container">';
        if ($enclosure = $item->get_enclosure()) {   
          echo '<img class="feed-thumb" style="float: left; width: 200px; margin-right: 10px;" src="' . $enclosure->get_thumbnail() . '" />';
        }
      ?>
              
      <a title="<?php printf( __( 'Posted %s', 'Konstruct Digital' ), $item->get_date('j F Y | g:i a') ); ?>" href="<?php echo esc_url( $item->get_permalink() ); ?>" target="_blank" rel="noopener">
      <?php 
        echo esc_html( $item->get_title() ); ?></a> - <?php echo esc_html( $item->get_date('F j, Y') );
      ?>
      <p>
        <?php 
          echo substr($item->get_description(), 0, 150); 
        ?> 
        <a title="<?php echo esc_html( $item->get_title() ); ?>" href="<?php echo esc_url( $item->get_permalink() );
      ?>">Continue Reading</a>
      </p>
          <?php echo '</div>'; ?>
        <?php endforeach; ?>
      <?php endif; ?>