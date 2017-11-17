<?php
/**
 * Template Name: Home Page
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); ?>

<!--Main Banner-->
        <div class="banner_wapper">
            <div class="slider_image"><!--img src="<?php echo get_template_directory_uri(); ?>/images/slider.png" alt=""-->
            <?php echo do_shortcode('[rev_slider homenew]'); ?>
            </div>
        </div>
    <!--End Main Banner-->
    
    <!--Main Contain-->
    <section class="contain_wapper">
    <?php while ( have_posts() ) : the_post(); 
    the_content();
    endwhile;
    ?>
        
    </section>
    <!--End Main Contain-->
<?php get_footer(); ?>
