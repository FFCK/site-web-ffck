<?php
/**
* Template Name: Master page
*
* @package WordPress
* @subpackage Twenty_Fourteen
* @since Twenty Fourteen 1.0
*/
get_header(); ?>

<!--Main Banner-->
<div class="banner_wapper master-slider">
  <div class="slider_image"><!--img src="<?php echo get_template_directory_uri(); ?>/images/slider.png" alt=""-->
    <?php
    $slidershortcode=get_field('shortcode');
    echo do_shortcode($slidershortcode); ?>
  </div>
</div>
<!--End Main Banner-->

<?php get_sidebar(); ?>

<!-- right -->
<div class="col-md-8 col-lg-9" >
  <div class="category_right masterpage">
    <div class="inner_image">
      <?php while ( have_posts() ) : the_post();
      $image_url = wp_get_attachment_url( get_post_thumbnail_id(get_the_id()) );
      if ($image_url != "") {
        echo '<img src="' . $image_url . '" alt="">';
      }
      ?>
    </div>
    <?php the_content(); endwhile; ?>
  </div>
</div>
<!-- right -->

</div> <!-- /.row -->
</div> <!-- /.category_wapper -->
</div> <!-- /.col-lg-12 -->
</div> <!-- /.row -->
</div> <!-- /.container -->
</section> <!-- /section.contain_wapper -->

<?php get_footer(); ?>
