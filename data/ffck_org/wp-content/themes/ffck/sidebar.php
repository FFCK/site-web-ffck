<?php
/**
 * The Sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?>
<!--Main Contain-->
        <section class="contain_wapper">
            	<!-- bradcumb -->
                <?php custom_breadcrumbs(); ?>
                	<!-- <div class="breadcrumb_wapper">
                    	<div class="container">
                        	<div class="row">
                            	<div class="col-lg-11 center-block float_none">
                                	<ul>
                                    	<li><a href="<?php echo home_url(); ?>">
                                    	<img src="<?php echo get_template_directory_uri(); ?>/images/home-icon.png"   alt=""></a></li>
                                        <li><?php echo get_the_title(); ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div> -->
                <!-- bradcumb -->
                 <!-- inner contain -->
                	<div class="container">
                        	<div class="row">
                            	<div class="col-lg-12 center-block float_none">
                                	 <div class="category_wapper">
                                     	<div class="row">
                                        	<!-- left -->
                                            	<div class="col-md-4 col-lg-3">
                                                	<div class="category_left">
														<!-- left link -->
                                                        <div class="left_cat">
                                                        	<!--h3><?php echo get_the_title(); ?></h3-->



                                                                    	 <?php
                                                                    	 wp_get_post_parent_id( $post_ID );

                                                                    	 if ($post->post_parent) {
																$ancestors = get_post_ancestors($post->ID);
																$root = count($ancestors)-1;
																$parent = $ancestors[$root];

															} else {
																$parent = $post->ID;
															}
															//echo $post->ID;
															//echo $parent;
															if($parent==0 || $parent==''){
																$menu_sho=get_field('menu_shortcode');
																}else{
                                                                    	 $menu_sho=get_field('menu_shortcode',$parent);
																	 }
                                                                    	 echo do_shortcode($menu_sho);
                                                                    	 ?>

                                                                <!--li><a href="<?php echo get_field('equipe_de_france'); ?>">équipe de france</a></li>
                                                                <li><a href="<?php echo get_field('en_live_!'); ?>">En live !</a></li>
                                                                <li><a href="<?php echo get_field('pratiquer_dans_un_club'); ?>">Pratiquer dans un club</a></li-->

                                                        </div>
                                                        <!-- left link -->
                                                    	<div class="club_box_inner">
                                                         <?php // dynamic_sidebar( 'sidebar_mailchamp' ); ?>
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
