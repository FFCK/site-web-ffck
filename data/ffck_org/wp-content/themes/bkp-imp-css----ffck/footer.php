<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?>
 <!--Main Footer-->
    <footer id="footer">
    	
    	<div class="logo_wapper" >
        	<div class="back-to-top">
            	<a href="#">
                	<span>
                    	<i class="fa fa-chevron-up"></i>
                        Retour en haut de page
                    </span>
                </a>
            </div>
        	<div class="container">
            	<div class="logo_wapper_sub">
            	<div class="logo_div"><img src="<?php echo get_template_directory_uri(); ?>/images/footer_logo.png"   alt=""></div>
                <div class="logo_slider">
                	<div class="flexslider carousel">
          				<ul class="slides">
							<?php

// check if the repeater field has rows of data
if( have_rows('Partner_Image') ):

 	// loop through the rows of data
    while ( have_rows('Partner_Image') ) : the_row();

        // display a sub field value
       echo '<li><img src="'. get_sub_field('logo').'"></li>';

    endwhile;

else :

    // no rows found

endif;

?>
                 
                        </ul>
                	</div>
                    </div>
                </div>
            </div>
        </div>
    	<div class="image_1"><img src="<?php echo get_template_directory_uri(); ?>/images/f_image_1.jpg" alt=""></div>
    	<div class="f_bg"></div>
        <div class="footer_wapper">
            <div class="container desktop_footer">
                <div class="row">
                	<div class="col-md-7">
                    	<div class="footer_left">
                        	<div class="row">
                            	<div class="col-sm-4">
                                	<h3>Sports olympique</h3>
                                    <ul>
                                    	 <?php $args = array(
											'menu'            => 'Sports olympique',
											'items_wrap'      => '<ul class="">%3$s</ul>',
											'before'          => '',
										  );	
											wp_nav_menu($args);  ?>
                                    </ul>
                                </div>
                                <div class="col-sm-4">
                                	<h3>Sports de compétiton</h3>
                                    <ul>
                                    	<?php $args = array(
											'menu'            => 'Sports de compétiton',
											'items_wrap'      => '<ul class="">%3$s</ul>',
											'before'          => '',
										  );	
										wp_nav_menu($args);  ?>
                                    </ul>
                                </div>
                                <div class="col-sm-4">
                                	<h3>Liens utiles</h3>
                                    <ul>
                                    	<?php $args = array(
											'menu'            => 'Liens utiles',
											'items_wrap'      => '<ul class="">%3$s</ul>',
											'before'          => '',
										  );	
										wp_nav_menu($args);  ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                            	<div class="col-sm-4">
                                	<h3>randonnées nautiques</h3>
                                    <ul>
                                    	<?php $args = array(
											'menu'            => 'randonnées nautiques',
											'items_wrap'      => '<ul class="">%3$s</ul>',
											'before'          => '',
										  );	
										wp_nav_menu($args);  ?>
                                    </ul>
                                </div>
                                <div class="col-sm-4">
                                	<h3>FFCK</h3>
                                    <ul>
                                    	<?php $args = array(
											'menu'            => 'ffck',
											'items_wrap'      => '<ul class="">%3$s</ul>',
											'before'          => '',
										  );	
										wp_nav_menu($args);  ?>
                                    </ul>
                                </div>
                                <div class="col-sm-4">
                                	<h3>Les clubs</h3>
                                    <ul>
                                    	<?php $args = array(
											'menu'            => 'Les clubs',
											'items_wrap'      => '<ul class="">%3$s</ul>',
											'before'          => '',
										  );	
									wp_nav_menu($args);  ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                    	<div class="footer_right">
                        	<div class="f_social">
                            	<h3>Nous suivre</h3>
                                <ul>
                                	<li><a href="#"><span class="fa fa-facebook-f"></span></a></li>
                                    <li><a href="#"><span class="fa fa-twitter"></span></a></li>
                                    <li><a href="#"><span class="fa fa-instagram"></span></a></li>
                                    <li><a href="#"><span class="fa fa-play"></span>FFCK TV</a></li>
                                </ul>
                            </div>
                            
                           <?php  dynamic_sidebar( 'footer_newslatter_block' ); ?> 
                            <!--form>
                            	<div class="formbox">
                                    <div class="row">
                                        <div class="col-sm-8">
	                                        <div class="inputbox"><input type="text" placeholder="Votre Email"></div>
                                        </div>
                                        <div class="col-sm-4">
	                                        <div class="submitbox"><input type="submit" value="S’inscrire"></div>
                                        </div>
                                    </div>
                                </div>
                            </form-->
                            <h3>Trouver un club</h3>
                            <p>Renseigner votre localisation ou choisissez la géolocalisation</p>
                            <form>
                            	<div class="formbox newslatter">
                                    <div class="row">
                                        <div class="col-sm-8">
	                                        <div class="inputbox"><input type="text" placeholder="Ville ou code postal"></div>
                                        </div>
                                        <div class="col-sm-4">
	                                        <div class="submitbox"><input type="submit" value="Rechercher"></div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            
                            <div class="toolbox"><a href="#">Boite à outils</a></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                	<div class="col-sm-12">
                    	<div class="footer_bootom">
                        	<div class="topline"></div>
                        	<div class="copyright"><span>FFCK</span> © 2015</div>
                            <ul>
                            	<?php $args = array(
											'menu'            => 'Footer_bottom',
											'items_wrap'      => '<ul class="">%3$s</ul>',
											'before'          => '',
										  );	
								wp_nav_menu($args);  ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- mobile footer start -->
            	<div class="mobile_footer">
            		<div class="container">
                    	<div class="f_social">
                            	<h3>Nous suivre</h3>
                                <ul
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
                                	<li><a href="<?php echo $fb_link; ?>"><span class="fa fa-facebook-f"></span></a></li>
                                    <li><a href="<?php echo $tw_link; ?>"><span class="fa fa-twitter"></span></a></li>
                                    <li><a href="<?php echo $in_link; ?>"><span class="fa fa-instagram"></span></a></li>
                                    <li><a href="<?php echo $pl_link; ?>"><span class="fa fa-play"></span>FFCK TV</a></li>
                                </ul>
                            </div>
                            
                            <div class="footer_news">
                            	<h3>Trouver un club</h3>
                                <p>Renseigner votre localisation ou choisissez la géolocalisation</p>
                                <form>
                                    <div class="formbox newslatter">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <div class="inputbox"><input type="text" placeholder="Ville ou code postal"></div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="submitbox"><input type="submit" value="Rechercher"></div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            
                            <div class="footer_nav">
                            	<h3>Liens utiles</h3>
                                    <ul>
                                    	<li><a href="#">Lorem ipsum</a></li>
                                        <li><a href="#">Dolor sit amet</a></li>
                                        <li><a href="#">Eras deus</a></li>
                                        <li><a href="#">Lorem ipsum</a></li>
                                        <li><a href="#">Dolor sit amet</a></li>
                                    </ul>
                            </div>
                            <div class="footer_nav">
                            	<h3>Les clubs</h3>
                                    <ul>
                                    	<li><a href="#">Lorem ipsum</a></li>
                                        <li><a href="#">Dolor sit amet</a></li>
                                        <li><a href="#">Eras deus</a></li>
                                        <li><a href="#">Lorem ipsum</a></li>
                                        <li><a href="#">Dolor sit amet</a></li>
                                    </ul>
                            </div>
                            
                            
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="footer_bootom">
                                        <div class="topline"></div>
                                        <div class="copyright"><span>FFCK</span> © 2015</div>
                                        <ul>
                                            <li><a href="#">Réalisation</a></li>
                                            <li><a href="#">Mentions légales</a></li>
                                            <li><a href="#">Plan du site</a></li>
                                            <li><a href="#">Contactez nous</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                    </div>
            	</div>
            <!-- mobile footer start -->
        </div>
    </footer>
    <!--End Main Footer-->
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/AnimOnScroll.js"></script>

<!-- Owl js -->
<script src="<?php echo get_template_directory_uri(); ?>/js/owl.carousel.js"></script>
<!-- Owl js -->

<!-- FlexSlider -->
  <script defer src="<?php echo get_template_directory_uri(); ?>/js/jquery.flexslider.js"></script>

  <script type="text/javascript">
    $(function(){
      SyntaxHighlighter.all();
    });
    $(window).load(function(){
      $('.flexslider').flexslider({
        animation: "slide",
        animationLoop: false,
        itemWidth: 210,
        itemMargin: 5,
        minItems: 2,
        maxItems: 5,
        start: function(slider){
          $('body').removeClass('loading');
        }
      });
    });
    
    $( ".search_block a" ).click(function() {
		$( ".search_block" ).toggleClass( "active" );
  $( "#search_form" ).toggle();
});
  </script>
<!-- FlexSlider -->


<!--Custom JS-->
<script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap-select.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/browser_selector.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/script.js"></script>
	<?php wp_footer(); ?>
</body>
</html>
