<?php
/**
 * The template for displaying a single job listings' content.
 *
 * @package Listify
 */

global $job_manager, $post;
?>

<div class="single_job_listing" itemscope itemtype="http://schema.org/LocalBusiness" <?php echo apply_filters('listify_job_listing_data', '', false ); ?>>

    <?php
      $imageUrl = "";
      // if (has_post_thumbnail( $post->ID ) ){
      //   $imageUrl = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' )[0];
      // }
      if (get_post_custom_values('photo_couverture')[0] != '') {
        $imageUrl = get_post_custom_values('photo_couverture')[0];
      }
    ?>
    <div <?php // echo apply_filters( 'listify_cover', 'listing-cover content-single-job_listing-hero', array( 'size' => 'full' ) ); ?> class="listing-cover content-single-job_listing-hero" style="background-size: cover; background-repeat:no-repeat; background-image: url('<?php echo $imageUrl; ?>')">

        <div class="content-single-job_listing-hero-wrapper cover-wrapper container">

            <div class="content-single-job_listing-hero-inner row">

                <div class="content-single-job_listing-hero-company col-sm-12">
                  <?php if (get_post_custom_values('logo_structure')[0] != ''): ?>
                    <?php $image = get_post_custom_values('logo_structure')[0]; ?>
                    <div class="companylogo" style="width: 120px; height:120px; auto; margin-bottom:5px; background-size: contain; background-repeat:no-repeat; background-image: url('<?php echo $image; ?>')"></div>
                  <?php endif; ?>

                    <?php do_action( 'listify_single_job_listing_meta' ); ?>
                </div>

                <!-- <div class="content-single-job_listing-hero-actions col-md-5 col-sm-12">
                    <?php do_action( 'listify_single_job_listing_actions' ); ?>
                </div> -->

            </div>

        </div>

    </div>

    <div id="primary" class="container">
        <div class="row content-area">

          <div class="trouverunclub">
            <a href="<?php echo get_site_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/ico-search.png" style="width:12px;margin-right:5px; margin-top:-4px">Trouver un club</a> > <span><?php the_title(); ?></span>
          </div>

        <?php if ( get_option( 'job_manager_hide_expired_content', 1 ) && 'expired' === $post->post_status ) : ?>

            <div class="woocommerce-message"><?php _e( 'This listing is expired.', 'listify' ); ?></div>

        <?php else : ?>

            <?php if ( listify_has_integration( 'woocommerce' ) ) : ?>
                <?php wc_print_notices(); ?>
            <?php endif; ?>

            <main id="main" class="site-main col-md-8 col-sm-7 col-xs-12" role="main">

                <?php do_action( 'single_job_listing_start' ); ?>

                <?php
                    // if ( ! dynamic_sidebar( 'single-job_listing-widget-area' ) ) {
                        $defaults = array(
                            'before_widget' => '<aside class="widget widget-job_listing">',
                            'after_widget'  => '</aside>',
                            'before_title'  => '<h3 class="widget-title widget-title-job_listing %s">',
                            'after_title'   => '</h3>',
                            'widget_id'     => ''
                        );

                        the_widget(
                            'Listify_Widget_Listing_Map',
                            array(
                                'title' => __( 'Listing Location', 'listify' ),
                                'icon'  => 'compass',
                                'map'   => 1,
                                'address' => 1,
                                'phone' => 1,
                                'web' => 1
                            ),
                            wp_parse_args( array( 'before_widget' => '<aside class="widget widget-job_listing listify_widget_panel_listing_map">' ), $defaults )
                        );

                        the_widget(
                            'Listify_Widget_Listing_Video',
                            array(
                                'title' => __( 'Video', 'listify' ),
                                'icon'  => 'ios-film-outline',
                            ),
                            wp_parse_args( array( 'before_widget' => '<aside class="widget widget-job_listing
                            listify_widget_panel_listing_video">' ), $defaults )
                        );

                        the_widget(
                            'Listify_Widget_Listing_Content',
                            array(
                                'title' => __( 'Renseignements', 'listify' ),
                                'icon'  => 'clipboard'
                            ),
                            wp_parse_args( array( 'before_widget' => '<aside class="widget widget-job_listing listify_widget_panel_listing_content">' ), $defaults )
                        );

                        the_widget(
                            'Listify_Widget_Listing_Comments',
                            array(
                                'title' => ''
                            ),
                            $defaults
                        );
                    // }
                ?>
                <?php // echo get_post_custom_values("club_email")[0]; ?>
                <?php do_action( 'single_job_listing_end' ); ?>

            </main>

            <?php get_sidebar( 'single-job_listing' ); ?>

        <?php endif; ?>
        </div>
    </div>
</div>
