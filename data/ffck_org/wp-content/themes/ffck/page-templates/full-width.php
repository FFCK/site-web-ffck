<?php
/**
 * Template Name: Full Width Page
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); ?>
<section class="contain_wapper">
<?php custom_breadcrumbs(); ?>
<div class="col-xs-12" >

  <div class="page-fullwidth">
    <div class="inner_image">
      <?php while ( have_posts() ) : the_post(); ?>
    </div>
    <?php the_content();
    endwhile; ?>
  </div>
</div>
</section>
</div>
</div>
</div>
</div>
</div>
<!-- inner contain -->
<!-- actus_wapper mobile -->
</section>
<?php

get_footer();
