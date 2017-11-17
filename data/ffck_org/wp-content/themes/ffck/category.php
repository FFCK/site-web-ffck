<?php
/**
* The template for displaying Category pages
*
* @link https://codex.wordpress.org/Template_Hierarchy
*
* @package WordPress
* @subpackage Twenty_Fourteen
* @since Twenty Fourteen 1.0
*/

get_header(); ?>

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
            $category = $wp_query->get_queried_object();
            $category->parent;

            $queried_object = get_queried_object();
            $taxonomy = $queried_object->taxonomy;
            $term_id = $queried_object->term_id;

            //eget_field('menu_shortcode',$taxonomy . '_' . $term_id);
            if($category->parent!=0 || $category->parent!=''){
              $menu_sho=get_field('menu_shortcode',$taxonomy . '_' . $category->parent);
            }
            else{
              $menu_sho=get_field('menu_shortcode',$taxonomy . '_' . $term_id);
            }
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

      <div class="col-md-9">
        <div class="row">

          <?php $cat_name=single_cat_title("", false); ?>
          <div class="col-xs-12">
            <h2 class="h2">Actualités <?php echo $cat_name; ?></h2>
          </div>
          <?php
          if ( have_posts() ) :
            // Start the Loop.
            while ( have_posts() ) : the_post();
            $image_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
            /*
            * Include the post format-specific template for the content. If you want to
            * use this in a child theme, then include a file called called content-___.php
            * (where ___ is the post format) and that will be used instead.
            */
            ?>


            <div class="col-md-4 actus_block_desktop">

              <div class="actus_box_second actus-page-box">

                <a href="<?php the_permalink(); ?>">
                  <div class="actus_box_image" style="background-image: url('<?php echo $image_url; ?>');background-repeat:no-repeat;background-size: cover;background-position: center;">
                  </div>
                </a>
                <div class="actus_box_Sub actus_box_sub_archive">
                  <div class="details_box">
                    <div class="icon_row">
                      <?php $cat_name=get_the_category();  ?>
                      <img src="<?php echo get_field('category_image', 'category_'.$cat_name[0]->term_taxonomy_id);  ?>"   alt="">


                      <a href="<?php echo home_url(); ?>/category/<?php echo $cat_name[0]->slug; ?>">
                        <?php
                        echo $cat_name[0]->slug;
                        ?>
                      </a>
                    </div>
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <p><?php echo excerpt(15); ?></p>
                  </div>
                  <div class="date"><span><?php echo get_the_date('d'); ?></span><?php echo get_the_date('M'); ?></div>
                  <div class="plue_link">
                    <a href="<?php the_permalink(); ?>">
                      <span>En savoir plus </span>
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <?php
            // the_content();
            //get_template_part( 'content', get_post_format() );
            ?><?php
          endwhile;
          // Previous/next post navigation.
          twentyfourteen_paging_nav();

          else :
            // If no content, include the "No posts found" template.
            //get_template_part( 'content', 'none' );

          endif;
          ?>
        </div>
      </div>
    </div>
  </div>
</section>

<?php

get_footer();
