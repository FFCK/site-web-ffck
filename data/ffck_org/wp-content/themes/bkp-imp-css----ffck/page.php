<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); ?>

<section class="contain_wapper">
            	<!-- bradcumb -->
                	<div class="breadcrumb_wapper">
                    	<div class="container">
                        	<div class="row">
                            	<div class="col-lg-11 center-block float_none">
                                	<ul>
                                    	<li><a href="#"><img src="images/home-icon.png"   alt=""></a></li>
                                        <li><a href="#">Sports olympiques </a></li>
                                        <li><a href="#">Le slalom</a></li>
                                        <li>Accueil slalom</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- bradcumb -->
                <!-- inner contain -->
                	<div class="container">
                        	<div class="row">
                            	<div class="col-lg-11 center-block float_none">
                                	 <div class="category_wapper">
                                     	<div class="row">
                                        	<!-- left -->
                                            	<div class="col-md-4 col-lg-3">
                                                	<div class="category_left">
                                                    	<div class="club_box_inner">
                                                            <h2>Trouver un club</h2>
                                                            <p>à proximité de</p>
                                                            <form>
                                                                <div class="main_club_box">
                                                                    <div class="sub_div">
                                                                        <input type="text" >
                                                                    </div>
                                                                    <span class="club_icon"><img src="images/club_icon2.png"  alt=""></span>
                                                                </div>
                                                                <div class="button_block">
                                                                    <input type="submit" value="Rechercher">
                                                                </div>
                                                            </form>
                                                         </div>
                                                         
                                                         <div class="courses_block">
                                                         	<h4>Suivez les courses <span>en live sur la ffck tv !</span></h4>
                                                            <div class="courses_slider">
                                                            	<div class="courses">
                                                                	<?php 
																	$args = array( 'post_type' => 'sidebar-add', 'posts_per_page' => -1 );
																	$loop = new WP_Query( $args );
																	$the_query = new WP_Query( $args );
																		while ( $loop->have_posts() ) : $loop->the_post();
																		$image_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
																	?>
																		<!-- item -->
                                                                    	<div class="item">
                                                                        	<div class="courses_box">
                                                                            	<div class="cur_img">
                                                                           	    	<img src="<?php echo $image_url; ?>"   alt=""> 
                                                                                </div>
                                                                                <p><?php echo get_the_title(); ?></p>
                                                                            </div>
                                                                        </div>
                                                                    <!-- item -->
																	<?php endwhile; ?>
                                                                   
                                                                </div>
                                                            </div>
                                                         </div>
                                                         
                                                         <div class="ad_image">
                                                   	     	<img src="images/ad_img2.png"   alt=""> 
                                                         </div>
                                                    </div>
                                                </div>
                                            <!-- left -->
                                            <!-- right -->
                                            	<div class="col-md-8 col-lg-9" >
                                                	<div class="category_right_singal">

<?php
	if ( is_front_page() && twentyfourteen_has_featured_posts() ) {
		// Include the featured content template.
		get_template_part( 'featured-content' );
	}
?>
	
			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();

					// Include the page content template.
					get_template_part( 'content', 'page' );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
				endwhile;
			?>

		</div><!-- #content -->
	</div><!-- #primary -->
	<?php get_sidebar( 'content' ); ?>
</div><!-- #main-content -->
</section>
<?php

get_footer();
