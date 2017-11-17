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
<!--Main Banner-->
        <div class="banner_wapper">
            <div class="slider_image"><!--img src="<?php echo get_template_directory_uri(); ?>/images/slider.png" alt=""-->
            <?php echo do_shortcode('[rev_slider category_slider]'); ?>
            </div>
        </div>
    <!--End Main Banner-->
	<!--Main Contain-->
        <section class="contain_wapper">
            	<!-- bradcumb -->
                	<div class="breadcrumb_wapper">
                    	<div class="container">
                        	<div class="row">
                            	<div class="col-lg-11 center-block float_none">
                                	<ul><?php 
                                	$queried_object = get_queried_object(); 
																			$taxonomy = $queried_object->taxonomy;
																			$term_id = $queried_object->term_id;  
                                	?>
                                    	<li><a href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/home-icon.png"   alt=""></a></li>
                                        <li><?php echo $queried_object->name; ?></li>
                                       
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
														<!-- left link -->
                                                        <div class="left_cat">
                                                        	<h3><?php echo $queried_object->name; ?></h3>
                                                        	 <ul>
                                                             	<li class="active"><a href="#">Compétitions</a>
                                                                	
                                                                    	 <?php $manu_arg = array(
																			'menu'            => 'sidebar_menu',
																			'items_wrap'      => '<ul class="sub_cat" id="%1$s">%3$s</ul>',
																			//'walker'          => new themeslug_walker_nav_menu
																		);	
																wp_nav_menu($manu_arg);   ?>
                                                                                </li>            
                                                                                            <?php $manu_arg = array(
																			'menu'            => 'sidebar_second_menu',
																			'items_wrap'      => '',
																			 
																			//'walker'          => new themeslug_walker_nav_menu
																		);	
																wp_nav_menu($manu_arg);   ?>                                  
                                                               
                                                               
                                                                <!--li><a href="#">équipe de france</a></li>
                                                                <li><a href="#">En live !</a></li>
                                                                <li><a href="#">Pratiquer dans un club</a></li-->
                                                             </ul>
                                                        </div>
                                                        <!-- left link -->
                                                    	<div class="club_box_inner">
                                                            <h2>Trouver un club</h2>
                                                            <p>à proximité de</p>
                                                            <?php echo do_shortcode('[mc4wp_form id="92"]'); ?>
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
                                                   	     	<img src="<?php echo get_field('image',$taxonomy . '_' . $term_id); ?>"   alt=""> 
                                                         </div>
                                                    </div>
                                                </div>
                                            <!-- left -->
                                                                                        <!-- right -->
                                            	<div class="col-md-8 col-lg-9" >
													
                                                	<div class="category_right">
                                                    	<div class="inner_image">
															<img src="<?php echo get_field('banner_image',$taxonomy . '_' . $term_id); ?>" alt="">
														</div>
                                                        <div class="presentation_block">
                                                        	<div class="big_title_inner">
                                                            	<h2>Présentation</h2>
                                                            </div>
                                                            	<?php
																			$queried_object = get_queried_object(); 
																			$taxonomy = $queried_object->taxonomy;
																			$term_id = $queried_object->term_id;  
																			?>
																			<p><?php echo category_description( $term_id ); ?> </p>
                                                            
                                                        </div>
                                                        <!-- une start -->
                                                        	<div class="une_wapper">
                                                            	<div class="big_title_inner">
                                                                	<h2>Actualités <span>à la une</span></h2>
                                                                    <div class="more_button_inner"><a href="#"><span><i class="fa fa-chevron-right"></i>
Toute les actualités </span></a></div>
                                                                </div>
                                                                <div class="une_block_main">
                                                                	<div class="une_block_desktop">

			<?php
			$counter=1;
					// Start the Loop.
					while ( have_posts() ) : the_post();
					
					$image_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
					if($counter<6){
						if($counter==1 || $counter==3)
						{ ?>
							<!-- item -->
								<div class="row">
									<?php } 
									if($counter==1){
									?>
									
										<div class="col-md-8 actus_block_desktop">
											<div class="actus_box">
												<div class="actus_box_Sub">
													 <div class="details_box">
														<div class="icon_row"><img src="<?php echo get_template_directory_uri(); ?>/images/salon_icon.png"   alt="">  
														<?php $cat_name=get_the_category(); ?>
														<a href="<?php echo home_url(); ?>/category/<?php echo $cat_name[0]->slug; ?>">
														  <?php 
																echo $cat_name[0]->slug;
															  ?>
															</a>
														</div>
														<h3><?php echo get_the_title(); ?></h3>
														<?php the_excerpt(); ?>
														<div class="plue_link">
															<a href="<?php the_permalink(); ?>">
																<span>En savoir plus</span>
															</a>
														</div>
													   
													 </div>
													  <div class="date"><span><?php echo get_the_date('d'); ?></span><?php echo get_the_date('M'); ?></div>
												</div>
												<div class="actus_box_image" style="background-image:url(<?php echo $image_url ?>);"></div>
											</div>
										</div>
										
									<?php }else{ ?>
										
									<?php  $hoglight=get_post_meta(get_the_id(),'wpcf-higlighted-news',true);  
											if($hoglight==1)
											{
													
											
											?>
									<div class="col-md-4 actus_block_desktop">
										<div class="actus_box_second third">
											<div class="actus_box_image"><img src="<?php echo $image_url ?>"   alt=""></div>
											<div class="actus_box_Sub">
												 <div class="details_box">
													<div class="icon_row"><img src="<?php echo get_template_directory_uri(); ?>/images/salon_icon2.png"   alt="">   
													<?php $cat_name=get_the_category(); ?>
														<a href="<?php echo home_url(); ?>/category/<?php echo $cat_name[0]->slug; ?>">
														  <?php 
																echo $cat_name[0]->slug;
															  ?>
															</a>
													</div>
													<h3><?php the_title(); ?></h3>
												 </div>
												  <div class="date"><span><?php echo get_the_date('d'); ?></span><?php echo get_the_date('M'); ?></div>
											</div>
										</div>
									</div>
                                        <?php }else{ ?>     
									
									<div class="col-md-4 actus_block_desktop">
											<div class="actus_box_second">

												<div class="actus_box_image" style="background-image:url(<?php echo $image_url ?>);"></div>
												<div class="actus_box_Sub">
													 <div class="details_box">
													 <div class="icon_row"><img src="<?php echo get_template_directory_uri(); ?>/images/salon_icon.png"   alt="">   
													 <?php $cat_name=get_the_category(); ?>
														<a href="<?php echo home_url(); ?>/category/<?php echo $cat_name[0]->slug; ?>">
														  <?php 
																echo $cat_name[0]->slug;
															  ?>
															</a></div>
													 <h3><?php the_title(); ?></h3>
												 </div>
													  <div class="date"><span><?php echo get_the_date('d'); ?></span><?php echo get_the_date('M'); ?></div>
												</div>
											</div>
										</div>
										
									<?php } ?>
									<?php } ?>
									<?php if($counter==2 || $counter==5 || $counter==count($posts)){ ?>
								</div>

							<!-- item -->
							
						<?php } } ?> <?php
					
					//get_template_part( 'content', get_post_format() );
						$counter++;
					endwhile; wp_reset_postdata(); wp_reset_query();
					
//====================    mobile view					==================
					?>
						</div>
					<div class="actus_mobile_block">
                    	<div class="actus-mobile">
							
					<?php 
						while ( have_posts() ) : the_post();
						$image_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
						?>
						 <!-- item -->
                        	<div class="item">
                            	<div class="actus_mobile_div">
                            	<div class="actus_box">
                                	
                                	<div class="actus_box_image" style="background-image:url(<?php echo $image_url; ?>);"></div>
                                    <div class="actus_box_Sub">
                                    	 <div class="details_box">
                                         	<div class="icon_row"><img src="<?php get_template_directory_uri(); ?>/images/salon_icon.png"   alt="">  
                                         	<a href="<?php echo home_url(); ?>/category/<?php echo $cat_name[0]->slug; ?>">
														  <?php 
																echo $cat_name[0]->slug;
															  ?>
															</a></div>
                                            <h3><?php the_title(); ?></h3>
                                            <?php the_excerpt(); ?>
                                            <div class="plue_link">
                                            	<a href="<?php the_permalink(); ?>">
                                                	<span>En savoir plus</span>
                                                </a>
                                            </div>
                                           
                                         </div>
                                          <div class="date"><span><?php echo get_the_date('d'); ?></span><?php echo get_the_date('M'); ?></div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <!-- item -->
					<?php	endwhile; 
					wp_reset_postdata(); 
					wp_reset_query();
					?>		
		</div>
			 </div>
			 </div>
            </div>
             <!-- accro block -->
                                                        	<div class="accro_wappre">
                                                            	<div class="ac_block">
                                                                    <div class="ac_title">
                                                                        <i><img src="<?php echo get_template_directory_uri(); ?>/images/radio_img.png"  alt=""></i>
                                                                        <h3>Les dernières vidéos <span>sur FFCk tv</span></h3>
                                                                        <div class="arrow"><i class="fa fa-chevron-down"></i></div>
                                                                    </div>
                                                                    <!-- hover div -->
                                                                    	<div class="hover_div first">
                                                                        	<div class="row">
                                                                            <?php   $query = new WP_Query( array(
																					'post_type' => 'video-gallery',
																					'posts_per_page' => -1,
																					'order' => 'ASC',
																				) );
																			?>
																			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
                                                                                <div class="col-lg-4 col-md-6 col-sm-6 tv_block_main">
                                                                                    <div class="tv_image">
																						<img alt="" src="<?php echo get_template_directory_uri(); ?>/images/tv_1.jpg">
																						<?php $video_provider=get_post_meta(get_the_id(),'video_provider',true);
																							  $vdo_id=get_post_meta(get_the_id(),'video_id',true);
																						 ?>
																						 <?php 
																						 if($video_provider=='youtube')
																						 { ?>
																							 <iframe width="100%" height="183" src="https://www.youtube.com/embed/<?php echo $vdo_id ?>" frameborder="0" allowfullscreen></iframe>
																					<?php }
																						 elseif($video_provider=='vimeo')
																						 { ?>
																							 <iframe src="//player.vimeo.com/video/<?php echo $vdo_id ?>" width="100%" height="183" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
																				<?php	 }
																						 elseif($video_provider=='dailymotion')
																						 { ?>
																							<iframe frameborder="0" width="100%" height="183" src="//www.dailymotion.com/embed/video/<?php echo $vdo_id ?>" allowfullscreen></iframe>

																				<?php	 }else{ ?>
																							<img src="<?php echo get_template_directory_uri(); ?>/images/tv_1.jpg"   alt="">
																				<?php }
																						 ?>
																						</div>
                                                                                    <h2><?php the_title(); ?></h2>
                                                                                    <p>Publiée: <?php echo get_the_date('d M Y') ?></p>
                                                                                </div>
                                                                              <?php endwhile;  wp_reset_query(); wp_reset_postdata(); ?>  
                                                                            </div>
                                                                            <div class="button_center">
                                                                            	<a href="#">
                                                                                	<span><i class="fa fa-chevron-right"></i>Voir toutes nos vidéos sur FFCK TV</span>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    <!-- hover div -->
                                                                </div>
                                                                <div class="ac_block">
                                                                    <div class="ac_title">
                                                                        <i><img src="<?php echo get_template_directory_uri(); ?>/images/share_img.png"  alt=""></i>
                                                                        <h3>L’actualités <span>des réseaux sociaux</span></h3>
                                                                        <div class="arrow"><i class="fa fa-chevron-down"></i></div>
                                                                    </div>
                                                                    <!-- hover div -->
                                                                    	<div class="hover_div second">
                                                                        	<div class="big_title">
                                                                                <h3>Toute l’actualité du slalom à travers les réseaux sociaux</h3>
                                                                                <div class="big_social">
                                                                                    <p>Trier les actualités par réseaux :</p>
								
																					<?php 
																					$fb=ot_get_option('facebook_link');
																					$tw=ot_get_option('twitter_link');
																					$in=ot_get_option('instagram_link');
																					$pl=ot_get_option('social_play');
																					if($fb!='')
																					{
																							$fb_link=ot_get_option('facebook_link');
																					}
																					if($tw!='')
																					{
																							$tw_link=ot_get_option('twitter_link');
																					}
																					if($fb!='')
																					{
																							$in_link=ot_get_option('instagram_link');
																					}
																					if($fb!='')
																					{
																							$pl_link=ot_get_option('social_play');
																					}
																				 ?>
                               
                                                                                   <a href="<?php echo $fb_link; ?>"><img alt="" src="<?php echo get_template_directory_uri(); ?>/images/facebook.png"></a>
                                                                                    <a href="<?php echo $tw_link; ?>"><img alt="" src="<?php echo get_template_directory_uri(); ?>/images/twitter.png"></a>
                                                                                     <a href="<?php echo $in_link; ?>"><img alt="" src="<?php echo get_template_directory_uri(); ?>/images/instagram.png"></a>
                                                                                     <a href="<?php echo $pl_link; ?>"><img alt="" src="<?php echo get_template_directory_uri(); ?>/images/youtube.png"></a>
                                                                               
                                                                                </div>
                                                                               <?php 
                                                                               $social=get_field('shortcode',$taxonomy . '_' . $term_id); 
                                                                               echo do_shortcode($social); ?>                                                                          </div>
                                                                          <div class="social_plug"></div>
                                                                        </div>
                                                                    <!-- hover div -->
                                                                 </div>
                                                                <div class="ac_block">   
                                                                    <div class="ac_title">
                                                                        <i><img src="<?php echo get_template_directory_uri(); ?>/images/cam_img.png"  alt=""></i>
                                                                        <h3>Galerie photos</h3>
                                                                        <div class="arrow"><i class="fa fa-chevron-down"></i></div>
                                                                        
                                                                    </div>
                                                                     <!-- hover div -->
                                                                    	<div class="hover_div second">
																			<?php
																			$queried_object = get_queried_object(); 
																			$taxonomy = $queried_object->taxonomy;
																			$term_id = $queried_object->term_id;  
																			?>
																			<div class="row">
                                                                        	 <?php $images=get_field('gallary_images',$taxonomy . '_' . $term_id);
                                                                        	 foreach( $images as $image ){ ?>
																			 <div class="col-lg-4 col-md-6 col-sm-6 tv_block_main">
																					<a href="<?php echo $image['url']; ?>">
																						 <img src="<?php echo $image['sizes']['thumbnail']; ?>" alt="<?php echo $image['alt']; ?>" />
																					</a>
																					<p><?php echo $image['caption']; ?></p>
																			  </div>
																		<?php	}
                                                                        	  ?>
                                                                        	  </div>
                                                                          <div class="social_plug"></div>
                                                                        </div>
                                                                    <!-- hover div -->
                                                                  </div>  
                                                            </div>
                                                        <!-- accro block -->
                                        <!-- result -->
                                            <div class="result_wapper">
                                                <div class="big_title_inner">
                                                    <h2>Derniers<span>résultats</span></h2>
                                                </div>
                                                <div class="tab_block">
                                                <ul class="nav nav-tabs" role="tablist">
                                                   
                                                 
                                             <?php  $queried_object = get_queried_object(); 
													$taxonomy = $queried_object->taxonomy;
													$term_id = $queried_object->term_id;  
													if(have_rows('tab_title',$taxonomy . '_' . $term_id))
													{
														$counter=1;
														while(have_rows('tab_title',$taxonomy . '_' . $term_id))
														{
															the_row();
															
															if($counter==1){ ?>
																
															
															<li role="presentation" class="active">
														<a href="#<?php echo $counter ?>" aria-controls="<?php echo $counter;?>" role="tab" data-toggle="tab"><?php echo get_sub_field('tab_title_text');?></a></li>
															
															
															<?php }else{ ?>
															<li role="presentation"><a href="#<?php echo $counter;?>" aria-controls="<?php echo $counter;?>" role="tab" data-toggle="tab"><?php echo get_sub_field('tab_title_text');?></a></li>
														<?php	}
														$counter++;
														}
														
														wp_reset_postdata();
														wp_reset_query();
													}
												?>
												</ul>
                                                 <div class="tab_container">
                                                 <div class="tab-content">
											 <?php  
													if(have_rows('tab_title',$taxonomy . '_' . $term_id))
													{
														$counter=1;
														while(have_rows('tab_title',$taxonomy . '_' . $term_id))
														{ 
															the_row();
															$active_class="";
															if($counter==1)
															{
																	$active_class="active";
															}
															?>
															
                                                       <!-- Tab 1 Contain  Start-->
                                                            <div role="tabpanel" class="tab-pane <?php echo $active_class; ?>" id="<?php echo $counter; ?>">
                                                                <h2><?php echo get_sub_field('tab_sub-title');?></h2>
                                                                <div class="row">
                                                                	<?php echo get_sub_field('tab_content', true, false); ?>
                                                                   
                                                                </div>
                                                            </div>
                                                        
                                                            <?php
                                                            $counter++;
                                                             }
																wp_reset_postdata();
																wp_reset_query();
														
															}  ?>
                                                       <!-- Tab 1 Contain End-->
                                                       
                                                  </div>
                                                  </div>
                                                </div>
                                            </div>
                                        <!-- result --> 
                                        				<!-- vanir -->
                                                        	<div class="venir_wapper">
                                                            	<div class="big_title_inner">
                                                                	<h2>compétitions <span>à venir</span></h2>
                                                                    <div class="more_button_inner">
                                                                    	<a href="#">
                                                                        	<span>
                                                                            	<i class="fa fa-chevron-right"></i>
																				Voir le calendrier 
                                                                             </span>
                                                                         </a>
                                                                    </div>
                                                                </div>
                                                                <div class="venir_wapper_sub">
                                                                	<div class="venir_slider">
                                                                    <?php	$query = new WP_Query( array(
																			'post_type' => 'event',
																			'posts_per_page' => -1,
																			
																			
																		) ); ?>
																		<?php		 
																			while ( $query->have_posts() ) : $query->the_post(); ?>
                                                                        <!-- item -->
                                                                        	<div class="item" >
                                                                            	<div class="venir_box_main"><!--heighlight-->
                                                                                	<div class="venir_box">
                                                                                    	<div class="date"><span><?php echo get_the_date('d'); ?></span><?php echo get_the_date('M'); ?></div>
                                                                                    	<div class="nav_icon2"></div>
                                                                                        <h4><?php the_title(); ?></h4>
                                                                                        <div class="address">
                                                                                            <span class="pin"> </span>
                                                                                            <p><?php echo get_post_meta(get_the_id(),'wpcf-event-place',true); ?></p>
                                                                                        </div>
                                                                                        <div class="address">
                                                                                            <span class="date3"> </span>
                                                                                            <p><?php echo get_post_meta(get_the_id(),'wpcf-event-address',true); ?></p>
                                                                                        </div>
                                                                                  </div>
                                                                                </div>
                                                                            </div>
                                                                        <!-- item -->
                                                                       <?php endwhile; wp_reset_query(); wp_reset_postdata(); ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <!-- vanir -->
                                                        
                                                    </div>
                                                </div>
                                            <!-- right -->
                                        </div>
                                     </div>
                                </div>
                            </div>
                        </div>
                <!-- inner contain -->
                <!-- actus_wapper mobile -->
</section>
<?php

get_footer('cat');
