<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); ?>



<?php
if ( is_front_page() && twentyfourteen_has_featured_posts() ) {
		// Include the featured content template.
  get_template_part( 'featured-content' );
}
?>

<section class="contain_wapper index page-actualites">
<?php if ( is_home() ) { echo '<div class="breadcrumb_wapper"><div class="container"><div class="row"><div class="col-lg-12 center-block float_none"><ul id="breadcrumbs" class="breadcrumbs"><li class="item-home"><a class="bread-link bread-home" href="http://www.ffck.org" title="Accueil"><img src="http://www.ffck.org/wp-content/themes/ffck/images/home-icon.png" alt=""></a></li><li class="item-current item-452"><strong class="bread-current bread-452"> Actualités</strong></li></ul></div></div></div></div>'; } ?>
 <div class="container">
   <div class="row">
   <?php if ( is_home() ) { echo '<div class="big_title_inner" style="margin-top:30px;"><h2>Actualités</h2></div>'; } ?>
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


          <div class="col-md-3 actus_block_desktop">

           <div class="actus_box_second">

             <?php
               $cat_name=get_the_category();
               if (strtolower($cat_name[0]->slug) == 'accueil' || strtolower($cat_name[0]->slug) == 'presse') {
                 if (strtolower($cat_name[1]->slug) == 'accueil' || strtolower($cat_name[1]->slug) == 'presse') {
                   $nomcat = $cat_name[2]->name;
                   $slugcat = $cat_name[2]->slug;
                   $idcat = $cat_name[2]->term_taxonomy_id;
                 }
                 else {
                   $nomcat = $cat_name[1]->name;
                   $slugcat = $cat_name[1]->slug;
                   $idcat = $cat_name[1]->term_taxonomy_id;
                 }
               }
               else {
                 $nomcat = $cat_name[0]->name;
                 $slugcat = $cat_name[0]->slug;
                 $idcat = $cat_name[0]->term_taxonomy_id;
               }
             ?>

             <a href="<?php the_permalink(); ?>">
             <div class="actus_box_image" style="background-image: url('<?php echo $image_url; ?>');background-repeat:no-repeat;background-size: cover;background-position: center;"></div>
            </a>
            <div class="actus_box_Sub">
              <div class="details_box">
                <div class="icon_row">
                  <img src="<?php echo get_field('category_image', 'category_'.$idcat);  ?>"   alt="">
                  <a href="<?php echo home_url(); ?>/category/<?php echo $slugcat; ?>">
                    <?php echo $nomcat; ?>
                  </a>
                </div>
                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
              </div>
              <div class="date"><span><?php echo get_the_date('d'); ?></span><?php echo get_the_date('M'); ?></div>
              <?php the_excerpt(); ?>
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
 </section>

 <?php

 get_footer();
