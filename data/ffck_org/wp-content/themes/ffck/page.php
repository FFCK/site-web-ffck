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

<!--Main Contain-->
        <?php get_sidebar(); ?>
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
