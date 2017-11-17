<?php
/**
* The Template for displaying all single posts
*
* @package WordPress
* @subpackage Twenty_Fourteen
* @since Twenty Fourteen 1.0
*/

get_header();  ?>


<!--Main Contain-->
<?php // get_sidebar(); ?>

<section class="contain_wapper">
<?php custom_breadcrumbs(); ?>
  <div class="container container-padding">
    <div class="row">
      <!-- left -->
      <div class="col-md-4 col-lg-3">
        <div class="category_left">
          <!-- left link -->
          <div class="left_cat">
            <!--h3><?php echo get_the_title(); ?></h3-->

            <?php

            global $wp_query;
            $post = $wp_query->post;

            $categories = get_the_category();
            foreach($categories as $category) {
              if ( $category->taxonomy != "accueil" || $category->taxonomy != "ffck" ) {
                $taxonomy = $category->taxonomy;
                $term_id = $category->term_id;
              }
            }

            $menu_sho=get_field('menu_shortcode',$taxonomy . '_' . $term_id);
            echo do_shortcode($menu_sho);
            ?>

            <!--li><a href="<?php echo get_field('equipe_de_france'); ?>">équipe de france</a></li>
            <li><a href="<?php echo get_field('en_live_!'); ?>">En live !</a></li>
            <li><a href="<?php echo get_field('pratiquer_dans_un_club'); ?>">Pratiquer dans un club</a></li-->

          </div>
          <!-- left link -->
          <div class="club_box_inner">
             <h2>Trouver un club</h2>
             <form id="form-annuaire" class="mc4wp-form mc4wp-form-92">
               <div class="mc4wp-form-fields">
                 <div class="main_club_box">
                   <div class="sub_div">
                     <input type="text" name="ville" placeholder="Ville ou code postal" required="">
                   </div>
                   <span class="club_icon"><img alt="" src="<?php get_site_url (); ?>/wp-content/themes/ffck/images/club_icon.png"></span>
                 </div>
                 <div class="button_block">
                   <input id="button-annuaire" type="submit" value="Rechercher">
                 </div>
               </div>
             </form>
          </div>

          <?php
            $sid_slid=get_field('sidebar_slider_shortcode');
            echo do_shortcode($sid_slid);
          ?>

          <div class="ad_image">
            <img src="<?php echo get_field('advotizement_image'); ?>"   alt="">
          </div>
        </div>
      </div>
      <!-- left -->


      <!-- right -->
      <div class="col-md-8 col-lg-9" >
        <div class="category_right_singal">
          <?php
            // Start the Loop.
            while ( have_posts() ) : the_post();
            $image_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
            ?>
            <h2 class="h2"><?php the_title(); ?><br><small><?php echo get_the_date(); ?></small></h2>
            <?php if ($image_url != ""): ?>
            <div class="inner_image" style="height:350px; width:auto; background:url('<?php echo $image_url; ?>') no-repeat center; -webkit-background-size: cover; background-size: cover;">
            </div>
          <?php endif; ?>
            <?php
            the_content();

            if ( comments_open() || get_comments_number() ) {
              //comments_template();
            }
            endwhile;
          ?>
        </div><!-- /.category_right_singal -->
      </div><!-- /.col -->
      <?php // get_sidebar( 'content' ); ?>
    </div>
  </div>
</section>

<?php get_footer(); ?>
