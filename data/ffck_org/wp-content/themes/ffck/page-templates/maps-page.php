<?php
/**
 * Template Name: Maps directory page
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); ?>

<div class="col-xs-12" >

  <div class="page-maps">
    <div class="inner_image">
      <?php while ( have_posts() ) : the_post(); ?>
    </div>
    <?php the_content();
    endwhile; ?>
  </div>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- inner contain -->
<!-- actus_wapper mobile -->
</section>
<script type="text/javascript">

  

  jQuery( window ).load(function() {
    var topiframe = jQuery('iframe').offset().top + 10;
    var heightiframe = ( jQuery(window).height() - topiframe );
    jQuery('iframe').attr('height',heightiframe);
  });

  jQuery( window ).resize(function() {
    var topiframe = jQuery('iframe').offset().top + 10;
    var heightiframe = ( jQuery(window).height() - topiframe );
    jQuery('iframe').attr('height',heightiframe);
  });
</script>
<?php

get_footer();
