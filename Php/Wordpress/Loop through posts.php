<?php
    // start query :
    $args1X = array( 'post_type' => 'blog', 'posts_per_page' => 20 );
    $loop1X = new WP_Query( $args1X );
    while ( $loop1X->have_posts() ) : $loop1X->the_post();?>
    <div class="" style="">
      <!-- title: -->
      <h2 class=""><?php the_field( 'page_title' ); ?></h2>
      <!-- content : -->
      <?php  $pageid = get_the_id();
      $content_post = get_post($pageid);
      $content = $content_post->post_content;
      $content = apply_filters('the_content', $content);
      $content = str_replace(']]>', ']]&gt;', $content);
      echo $content; ?>
    </div>
<?php endwhile; ?>
