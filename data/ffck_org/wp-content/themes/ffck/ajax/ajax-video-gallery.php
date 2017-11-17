<?php

$folder = substr(substr($_SERVER["REQUEST_URI"],1), 0, strpos(substr($_SERVER["REQUEST_URI"],1), "/"));

if ( strpos($_SERVER["DOCUMENT_ROOT"], "wamp") != false ) {
  $ajax_url = realpath($_SERVER["DOCUMENT_ROOT"]).'/wp-load.php';
}
else {$ajax_url = realpath($_SERVER["DOCUMENT_ROOT"]).'/'.'/wp-load.php';
}
require($ajax_url);

$query = new WP_Query(array(
  'post_type' => 'video-gallery',
  'posts_per_page' => 4,
  'order' => 'DESC',
  ));
  if ( $query->have_posts() ) { ?>

  <div class="ffck_tv_block">
    <div class="row">
      <?php while ( $query->have_posts() ) : $query->the_post(); ?>
        <div class=" col-md-3 tv_block_main">
          <div class="tv_image">
            <img src="<?php echo get_template_directory_uri(); ?>/images/tv_1.jpg" alt="">
            <?php $video_provider = get_post_meta(get_the_id(),'video_provider',true); $vdo_id=get_post_meta(get_the_id(),'video_id',true); ?>
            <?php if ( $video_provider=='youtube' ) { ?>
            <iframe width="100%" height="183" src="https://www.youtube.com/embed/<?php echo $vdo_id ?>" frameborder="0" allowfullscreen></iframe>
            <?php } elseif ($video_provider=='vimeo') { ?>
            <iframe src="//player.vimeo.com/video/<?php echo $vdo_id ?>" width="100%" height="183" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
            <?php	 } elseif($video_provider=='dailymotion') { ?>
            <iframe frameborder="0" width="100%" height="183" src="//www.dailymotion.com/embed/video/<?php echo $vdo_id ?>" allowfullscreen></iframe>
            <?php } else { ?>
            <!--img src="<?php echo get_template_directory_uri(); ?>/images/tv_1.jpg"   alt=""-->
            <?php } ?>
          </div>
          <h2><?php echo get_the_title(); ?></h2>
          <p>Publiée: <?php echo get_the_date('d M Y'); ?></p>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
  <?php wp_reset_postdata();  ?>
  <div class="mobile_tv_block">
    <div class="tv-mobile">
      <?php while ( $query->have_posts() ) : $query->the_post(); ?>
        <div class="item">
          <div class="tv_mobile tv_block_main">
            <div class="tv_image">
              <img src="<?php echo get_template_directory_uri(); ?>/images/tv_1.jpg"   alt="">
              <?php if($video_provider=='youtube') { ?>
              <iframe width="100%" height="183" src="https://www.youtube.com/embed/<?php echo $vdo_id ?>" frameborder="0" allowfullscreen></iframe>
              <?php } elseif ($video_provider=='vimeo') { ?>
              <iframe src="//player.vimeo.com/video/<?php echo $vdo_id ?>" width="100%" height="183" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
              <?php	 } elseif ($video_provider=='dailymotion') { ?>
              <iframe frameborder="0" width="100%" height="183" src="//www.dailymotion.com/embed/video/<?php echo $vdo_id ?>" allowfullscreen></iframe>
              <?php	 } else{ ?>
              <!--img src="<?php echo get_template_directory_uri(); ?>/images/tv_1.jpg"   alt=""-->
              <?php } ?>
            </div>
            <h2><?php echo get_the_title(); ?></h2>
            <p>Publiée: <?php echo get_the_date('d M Y'); ?></p>
          </div>
        </div>
      <?php endwhile; wp_reset_postdata(); wp_reset_query(); ?>
    </div>
  </div>

  <?php } ?>
